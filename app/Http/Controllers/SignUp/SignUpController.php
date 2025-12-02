<?php

namespace App\Http\Controllers\SignUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    public function create()
    {
        return view('page.signup.signup');
    }

    public function store(Request $request)
    {
        // VALIDASI SEDERHANA (yang penting email ITS valid)
        $validated = $request->validate([
            'name'  => ['nullable', 'string', 'max:100'],

            'email' => [
                'required',
                'email',
                'max:150',
                // hanya izinkan email ITS
                'regex:/@(student\.)?its\.ac\.id$/i',
                'unique:app_user,email_its',
            ],

            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        // SIMPAN KE TABEL app_user
        AppUser::create([
            'nama'          => $validated['name'] ?? null,
            'email_its'     => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'no_telepon'    => $validated['phone'] ?? null,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}