<?php

namespace App\Http\Controllers\EditakundanHapusakun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AkunController extends Controller
{
    /**
     * Ambil NRP dari email ITS.
     * Contoh: 5026231151@student.its.ac.id -> 5026231151
     */
    protected function getNrpFromEmail(?string $email): string
    {
        if (!$email) {
            return '-';
        }

        $nrp = strstr($email, '@', true);

        return $nrp !== false && $nrp !== '' ? $nrp : '-';
    }

    /**
     * Delete old photo from Supabase storage
     */
    protected function deleteOldPhoto($photoUrl, $supabaseUrl, $supabaseKey)
    {
        try {
            if (!$photoUrl) {
                return true;
            }

            // Extract path from full URL or use directly if it's a path
            if (str_starts_with($photoUrl, 'http')) {
                // Extract path dari full URL: https://...supabase.co/storage/v1/object/public/foto-profile/7/...
                $path = str_replace("{$supabaseUrl}/storage/v1/object/public/", '', $photoUrl);
            } else {
                // Already a path
                $path = $photoUrl;
            }

            $deleteUrl = "{$supabaseUrl}/storage/v1/object/{$path}";

            Log::info('Deleting old photo from Supabase', [
                'path' => $path,
                'url' => $deleteUrl,
            ]);

            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                ])->delete($deleteUrl);

            Log::info('Supabase delete response', [
                'status' => $response->status(),
                'success' => $response->successful(),
            ]);

            return $response->successful() || $response->status() === 404; // 404 means file doesn't exist, which is fine
        } catch (\Exception $e) {
            Log::error('Error deleting old photo', [
                'error' => $e->getMessage(),
            ]);
            // Don't throw, just log - old photo deletion shouldn't block new upload
            return false;
        }
    }

    /**
     * Tampilkan halaman edit profil (editprofile.blade.php).
     */
    public function edit(Request $request)
    {
        // Ambil user yang sedang login dari session
        $userId = $request->session()->get('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        // Ambil data user dari database
        $user = AppUser::where('userid', $userId)->first();

        if (!$user) {
            $request->session()->flush();
            return redirect()->route('login');
        }

        // Generate NRP dari email ITS
        $nrp = $this->getNrpFromEmail($user->email_its);

        return view('page.profile.editprofile', [
            'user' => $user,
            'nrp'  => $nrp,
        ]);
    }

    /**
     * Update data akun.
     */
    public function update(Request $request)
    {
        $userId = $request->session()->get('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = AppUser::where('userid', $userId)->first();

        if (!$user) {
            $request->session()->flush();
            return redirect()->route('login');
        }

        // Log request data untuk debugging
        Log::info('Update akun request', [
            'has_photo' => $request->hasFile('photo'),
            'all_files' => $request->allFiles(),
            'all_input' => $request->except(['nama', 'phone', 'password']),
        ]);

        // Handle photo upload ke Supabase SEBELUM validasi
        if ($request->hasFile('photo')) {
            Log::info('Photo file detected, proceeding with upload');

            try {
                $file = $request->file('photo');

                // Validasi file terlebih dahulu
                if (!$file->isValid()) {
                    throw new \Exception('File upload tidak valid');
                }

                $mimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf',
                             'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                if (!in_array($file->getMimeType(), $mimeTypes)) {
                    throw new \Exception('Tipe file tidak didukung: ' . $file->getMimeType());
                }

                // Max file size: 5120KB (same as validation rule 'max:5120')
                $maxSizeKB = 5120;
                $fileSizeKB = $file->getSize() / 1024;
                if ($fileSizeKB > $maxSizeKB) {
                    throw new \Exception('Ukuran file terlalu besar (max ' . $maxSizeKB . 'KB)');
                }

                $timestamp = time();
                $originalName = $file->getClientOriginalName();
                // Sanitize filename: replace spaces with hyphens
                $sanitizedName = str_replace(' ', '-', $originalName);
                $filename = $timestamp . '_' . $sanitizedName;
                $filePath = "foto-profile/{$userId}/{$filename}";

                // Siapkan data untuk upload ke Supabase
                $fileContent = file_get_contents($file);

                // Baca langsung dari .env file (bypass cache)
                $envPath = base_path('.env');
                $envContent = file_get_contents($envPath);

                // Parse .env
                preg_match('/SUPABASE_URL=(.*)/', $envContent, $urlMatch);
                preg_match('/SUPABASE_SERVICE_ROLE=(.*)/', $envContent, $keyMatch);

                $supabaseUrl = trim($urlMatch[1] ?? '');
                $supabaseKey = trim($keyMatch[1] ?? '');

                // Validasi environment variables
                if (!$supabaseUrl || !$supabaseKey) {
                    throw new \Exception('Supabase configuration missing: URL=' . ($supabaseUrl ? 'OK' : 'MISSING') .
                        ', KEY=' . ($supabaseKey ? 'OK' : 'MISSING'));
                }

                // Construct URL dengan benar
                $uploadUrl = "{$supabaseUrl}/storage/v1/object/{$filePath}";

                Log::info('Supabase foto upload attempt', [
                    'url' => $uploadUrl,
                    'file' => $filename,
                    'path' => $filePath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'key_length' => strlen($supabaseKey),
                    'key_preview' => substr($supabaseKey, 0, 30) . '...' . substr($supabaseKey, -10),
                ]);

                // Upload ke Supabase Storage via REST API
                // Menggunakan service role key untuk bypass row-level security
                $response = Http::timeout(60)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $supabaseKey,
                        'Content-Type' => $file->getMimeType(),
                    ])->withBody($fileContent, $file->getMimeType())
                    ->post($uploadUrl);

                Log::info('Supabase foto upload response', [
                    'status' => $response->status(),
                    'success' => $response->successful(),
                    'body' => $response->body(),
                ]);

                if ($response->failed()) {
                    throw new \Exception('Gagal upload file ke Supabase: ' . $response->body());
                }

                // Delete old photo if exists
                if ($user->foto_profile) {
                    $this->deleteOldPhoto($user->foto_profile, $supabaseUrl, $supabaseKey);
                }

                // Simpan full URL ke database
                $encodedPath = str_replace(' ', '%20', $filePath);
                $fullPhotoUrl = "{$supabaseUrl}/storage/v1/object/public/{$encodedPath}";

                $user->foto_profile = $fullPhotoUrl;
                $user->save();

                Log::info('Foto profile uploaded and saved', [
                    'url' => $fullPhotoUrl,
                    'user_id' => $userId,
                ]);

            } catch (\Exception $e) {
                Log::error('Supabase foto upload error', [
                    'error' => $e->getMessage(),
                    'user_id' => $userId,
                ]);

                return redirect()->route('account.edit')
                    ->with('error', 'Gagal upload foto: ' . $e->getMessage());
            }
        }

        // Validasi input (TANPA photo field karena sudah diproses)
        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        // Update nama
        $user->nama = $validated['nama'];

        // Map input "phone" ke kolom DB "no_telepon"
        if (array_key_exists('phone', $validated)) {
            $user->no_telepon = $validated['phone'];
        }

        // Kalau password diisi
        if (!empty($validated['password'])) {
            $user->password_hash = Hash::make($validated['password']);
        }

        // Save (foto_profile sudah set di atas jika ada upload)
        $user->save();

        // Update session supaya nama & email di profile ikut berubah
        $request->session()->put('user_name',  $user->nama);
        $request->session()->put('user_email', $user->email_its);

        return redirect()->route('profile')
            ->with('status', 'Akun berhasil diperbarui.');
    }

    /**
     * Hapus akun user yang sedang login.
     */
    public function destroy(Request $request)
    {
        $userId = $request->session()->get('user_id');

        if ($userId) {
            $user = AppUser::where('userid', $userId)->first();

            if ($user) {
                $user->delete();
            }

            $request->session()->flush();
        }

        return redirect()->route('signup')
            ->with('status', 'Akun berhasil dihapus.');
    }
}

