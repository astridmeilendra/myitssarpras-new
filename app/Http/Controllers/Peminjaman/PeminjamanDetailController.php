<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanDetailController extends Controller
{
    /**
     * Menampilkan detail peminjaman
     */
    public function show(Request $request, $peminjamanId)
    {
        $userId = Auth::id();

        // Ambil status terakhir dulu
        $statusTerakhir = DB::table('riwayat_status')
            ->where('peminjamanid', $peminjamanId)
            ->orderBy('statusid', 'desc')
            ->first();

        $status = $statusTerakhir?->nama_status ?? 'Menunggu';

        // Ambil detail peminjaman dengan informasi terkait
        $peminjaman = DB::table('peminjaman as p')
            ->join('ruangan as r', 'p.ruanganid', '=', 'r.ruanganid')
            ->join('app_user as u', 'p.userid', '=', 'u.userid')
            ->where('p.peminjamanid', $peminjamanId)
            ->where('p.userid', $userId) // Pastikan user hanya bisa lihat data miliknya
            ->select(
                'p.peminjamanid',
                'p.tanggal',
                'p.nama_shift',
                'p.keterangan',
                'p.dokumen',
                'p.userid',
                'r.ruanganid',
                'r.nama_ruangan',
                'r.lokasi_ruangan',
                'r.kapasitas',
                'r.foto',
                'r.fasilitas',
                'r.deskripsi',
                'u.nama',
                'u.no_telepon',
                'u.email_its'
            )
            ->first();

        if (!$peminjaman) {
            return redirect()->route('home')->with('error', 'Peminjaman tidak ditemukan');
        }

        // Ambil riwayat status lengkap
        $riwayatStatus = DB::table('riwayat_status')
            ->where('peminjamanid', $peminjamanId)
            ->orderBy('statusid', 'asc')
            ->get();

        // Format foto - ambil foto pertama jika ada multiple links
        $fotoUrl = null;

        if ($peminjaman->foto) {
            // Split foto jika ada multiple links dipisah koma
            $photos = array_filter(array_map('trim', explode(',', $peminjaman->foto)));

            if (!empty($photos)) {
                $firstPhoto = $photos[0];

                if (str_starts_with($firstPhoto, 'http://') || str_starts_with($firstPhoto, 'https://')) {
                    $fotoUrl = $firstPhoto;
                } else {
                    $fotoUrl = asset('storage/' . ltrim($firstPhoto, '/'));
                }
            }
        }

        // Format dokumen URL untuk akses
        $dokumenUrl = null;
        if ($peminjaman->dokumen) {
            // Gunakan route download untuk serve dokumen securely
            $dokumenUrl = route('peminjaman.download-dokumen', ['peminjamanid' => $peminjamanId]);
        }

        // Selalu gunakan view yang sama, cukup pass status ke view
        return view('page.peminjaman.detail-peminjaman', [
            'peminjaman' => $peminjaman,
            'riwayatStatus' => $riwayatStatus,
            'statusTerakhir' => $status,
            'fotoUrl' => $fotoUrl,
            'dokumenUrl' => $dokumenUrl
        ]);
    }

    /**
     * Download dokumen peminjaman
     */
    public function downloadDokumen(Request $request, $peminjamanid)
    {
        $userId = Auth::id();

        // Ambil dokumen path
        $peminjaman = DB::table('peminjaman as p')
            ->where('p.peminjamanid', $peminjamanid)
            ->where('p.userid', $userId) // Security: pastikan user hanya bisa download dokumennya sendiri
            ->select('p.dokumen')
            ->first();

        if (!$peminjaman || !$peminjaman->dokumen) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        $filePath = $peminjaman->dokumen;

        // Parse path - cek apakah file ada
        if (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://')) {
            // Jika URL, redirect ke URL tersebut
            return redirect($filePath);
        }

        // Jika path relatif, konversi ke URL Supabase
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');
        $supabaseBucket = 'dokumen-peminjaman';

        // Konversi path relatif menjadi URL Supabase
        $dokumentUrl = "{$supabaseUrl}/storage/v1/object/public/{$supabaseBucket}/{$filePath}";

        return redirect($dokumentUrl);
    }

    /**
     * Upload surat peminjaman dan ubah status ke Menunggu
     */
    public function submitUploadSurat(Request $request, $peminjamanid)
    {
        $userId = Auth::id();

        $peminjaman = DB::table('peminjaman')
            ->where('peminjamanid', $peminjamanid)
            ->where('userid', $userId)
            ->first();

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Peminjaman tidak ditemukan'], 404);
        }

        $statusTerakhir = DB::table('riwayat_status')
            ->where('peminjamanid', $peminjamanid)
            ->orderBy('statusid', 'desc')
            ->value('nama_status');

        if ($statusTerakhir !== 'Verifikasi Data') {
            return response()->json(['success' => false, 'message' => 'Status peminjaman tidak valid untuk upload surat'], 422);
        }

        if (!$request->hasFile('surat')) {
            return response()->json(['success' => false, 'message' => 'File surat tidak ditemukan'], 422);
        }

        $file = $request->file('surat');

        // Validasi file
        $allowedMimes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($file->getClientOriginalExtension()), $allowedMimes)) {
            return response()->json(['success' => false, 'message' => 'Format file tidak valid. Gunakan PDF, DOC, DOCX, JPG, atau PNG'], 422);
        }
        if ($file->getSize() > 5 * 1024 * 1024) {
            return response()->json(['success' => false, 'message' => 'Ukuran file maksimal 5MB'], 422);
        }

        try {
            $timestamp = time();
            $filename = $timestamp . '_' . $file->getClientOriginalName();
            $filePath = "dokumen_peminjaman/{$userId}/{$filename}";
            $fileContent = file_get_contents($file->getRealPath());


            // Logging kalau tidak bisa upload surat
            \Log::info('SUPABASE DEBUG', [
            'env_exists' => file_exists(base_path('.env')),
            'bucket_env' => env('SUPABASE_BUCKET'),
             'url_env' => env('SUPABASE_URL'),
             'service_role_env' => env('SUPABASE_SERVICE_ROLE') ? 'ADA' : 'KOSONG',
            ]);

            // Baca Supabase config dari .env
            $envContent = file_get_contents(base_path('.env'));
            preg_match('/SUPABASE_URL=(.*)/', $envContent, $urlMatch);
            preg_match('/SUPABASE_SERVICE_ROLE=(.*)/', $envContent, $keyMatch);
            preg_match('/SUPABASE_BUCKET=(.*)/', $envContent, $bucketMatch);

            $supabaseUrl = trim($urlMatch[1] ?? '');
            $supabaseKey = trim($keyMatch[1] ?? '');
            $supabaseBucket = trim($bucketMatch[1] ?? '');

            if (!$supabaseUrl || !$supabaseBucket || !$supabaseKey) {
                throw new \Exception('Konfigurasi Supabase tidak lengkap');
            }

            $uploadUrl = "{$supabaseUrl}/storage/v1/object/{$supabaseBucket}/{$filePath}";

            $response = \Illuminate\Support\Facades\Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type'  => $file->getMimeType(),
                ])->withBody($fileContent, $file->getMimeType())
                ->post($uploadUrl);

            if ($response->failed()) {
                throw new \Exception('Gagal upload ke Supabase: ' . $response->body());
            }

            $dokumenPath = "{$supabaseUrl}/storage/v1/object/public/{$supabaseBucket}/{$filePath}";

            DB::beginTransaction();

            // Simpan dokumen ke peminjaman
            DB::table('peminjaman')
                ->where('peminjamanid', $peminjamanid)
                ->update(['dokumen' => $dokumenPath]);

            // Tambah status Menunggu
            DB::table('riwayat_status')->insert([
                'peminjamanid' => $peminjamanid,
                'nama_status'  => 'Menunggu',
                'waktu_update' => now(),
                'keterangan'   => 'Surat permohonan telah diupload. Menunggu persetujuan Sarpras.',
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Surat berhasil diupload. Status berubah menjadi Menunggu.']);

        } catch (\Exception $e) {

            \Log::error('UPLOAD SURAT ERROR', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            ]);

             DB::rollBack();

            return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengupload surat',
            'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
         ], 500);
}
    }

    /**
     * Batalkan peminjaman
     */
    public function cancel(Request $request, $peminjamanid)
    {
        $userId = Auth::id();

        // Ambil peminjaman dan status terakhir
        $peminjaman = DB::table('peminjaman')
            ->where('peminjamanid', $peminjamanid)
            ->where('userid', $userId) // Security: pastikan user hanya bisa batalkan miliknya
            ->first();

        if (!$peminjaman) {
            return redirect()->route('riwayat')->with('error', 'Peminjaman tidak ditemukan');
        }

        // Cek status terakhir - hanya bisa batalkan jika masih "Menunggu"
        $statusTerakhir = DB::table('riwayat_status')
            ->where('peminjamanid', $peminjamanid)
            ->orderBy('statusid', 'desc')
            ->first();

        $status = $statusTerakhir?->nama_status ?? 'Menunggu';

        if (!in_array($status, ['Menunggu', 'Verifikasi Data'])) {
            return redirect()->route('peminjaman.detail', $peminjamanid)
                ->with('error', 'Hanya peminjaman dengan status Menunggu atau Verifikasi Data yang dapat dibatalkan');
        }

        // Buat riwayat status baru dengan status "Dibatalkan"
        DB::table('riwayat_status')->insert([
            'peminjamanid' => $peminjamanid,
             'nama_status' => 'Dibatalkan',
             'waktu_update' => now(),
             'keterangan' => 'Peminjaman dibatalkan oleh peminjam'
        ]);

        return redirect()->route('peminjaman.detail', $peminjamanid)
            ->with('success', 'Peminjaman berhasil dibatalkan');
    }
}
