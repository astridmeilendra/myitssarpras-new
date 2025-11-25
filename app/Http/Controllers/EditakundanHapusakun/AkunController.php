<?php

namespace App\Http\Controllers\EditakundanHapusakun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\Hash;

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

        // Validasi input
        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:30'],   // nama field di form
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        // Update nama
        $user->nama = $validated['nama'];

        // Map input "phone" ke kolom DB "no_telepon"
        if (array_key_exists('phone', $validated)) {
            $user->no_telepon = $validated['phone'];   // <- di DB kolomnya no_telepon
        }

        // Kalau password diisi (kalau nanti kamu pakai)
        if (!empty($validated['password'])) {
            $user->password_hash = Hash::make($validated['password']);
        }

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
