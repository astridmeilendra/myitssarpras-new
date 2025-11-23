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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = AppUser::where('email_its', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
