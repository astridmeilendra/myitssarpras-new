<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('page.loginpage.signin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cari user berdasarkan email ITS
        $user = AppUser::where('email_its', $credentials['email'])->first();

        // Cek apakah user ada dan password cocok
        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        $request->session()->put('user_id', $user->userid);
        $request->session()->put('user_name', $user->nama);
        $request->session()->put('user_email', $user->email_its);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
