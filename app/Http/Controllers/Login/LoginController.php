<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        return view('page.loginpage.signin');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cari user berdasarkan email
        $user = AppUser::where('email_its', $credentials['email'])->first();

        // Cek apakah user ada dan password cocok
        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        // Login berhasil → redirect ke homepage
        return redirect('/home');
    }
}
