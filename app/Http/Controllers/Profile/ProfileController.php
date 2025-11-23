<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUser;

class ProfileController extends Controller
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

    public function show(Request $request)
    {
        // Ambil user id dari session
        $userId = $request->session()->get('user_id');

        // Kalau belum login → lempar ke login
        if (!$userId) {
            return redirect()->route('login');
        }

        // Ambil data user dari DB
        $user = AppUser::where('userid', $userId)->first();

        if (!$user) {
            // Kalau user nggak ketemu, bersihkan session
            $request->session()->flush();
            return redirect()->route('login');
        }

        // Hitung NRP dari email ITS
        $nrp = $this->getNrpFromEmail($user->email_its);

        return view('page.profile.profile', [
            'user' => $user,
            'nrp'  => $nrp,
        ]);
    }
}
