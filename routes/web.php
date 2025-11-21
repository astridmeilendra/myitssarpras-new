<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SignUp\SignUpController;
use App\Http\Controllers\Login\LoginController;

// Navbar
Route::get('/home', function () {
    return view('page/homepage');
})->name('home');

Route::get('/riwayat', function () {
    return view('page/riwayat/riwayat');
})->name('riwayat');

Route::get('/search', function () {
    return view('page/cariruangan/cariruangan');
})->name('search');

Route::get('/info', function () {
    return view('info');
})->name('info');

Route::get('/profile', function () {
    return view('page/profile/profile');
})->name('profile');

//DB Connection
Route::get('/cek-koneksi', function () {
    $peminjaman = DB::table('peminjaman')
        ->join('app_user', 'peminjaman.userid', '=', 'app_user.userid')
        ->select('peminjaman.peminjamanid', 'app_user.nama', 'peminjaman.keterangan', 'peminjaman.dokumen')
        ->get();

    return view('cek-koneksi', ['peminjaman' => $peminjaman]);
});

// Auth - arahkan root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// LOGIN
Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

// SIGNUP
Route::get('/signup', [SignUpController::class, 'create'])
    ->name('signup');   // <-- ini yang dipakai di Blade: route('signup')

Route::post('/signup', [SignUpController::class, 'store'])
    ->name('signup.store');

// Cariruangan
Route::get('/seacrh', function () {
    return view('page/cariruangan/cariruangan');
});

//Cariruangan parsial
Route::get('/search-persial', function () {
    return view('page/cariruangan/cariruanganparsial');
});

// Ruangan
Route::get('/ruangan', function () {
    return view('page/ruangan/detail-ruangan');
});

// Success
Route::get('/success', function () {
    return view('page/peminjaman/success');
});

// Cariruangan
Route::get('/cariruangan', function () {
    return view('page/cariruangan/cariruangan');
});

//Cariruangan parsial
Route::get('/cariruanganparsial', function () {
    return view('page/cariruangan/cariruanganparsial');
});

//Riwayat: Peminjaman Dibatalkan
Route::get('/batal', function () {
    return view('page/riwayat/batal');
});

//Riwayat: Peminjaman Diselesaikan
Route::get('/selesai', function () {
    return view('page/riwayat/selesai');
});

//Riwayat: Dalam Peminjaman
Route::get('/dalam', function () {
    return view('page/riwayat/dalam');
});

//Riwayat: Konfirmasi Pembatalan
Route::get('/konfirmasi', function () {
    return view('page/riwayat/konfirmasi');
});

//Riwayat: Permintaan Gagal Dibatalkan
Route::get('/fail', function () {
    return view('page/riwayat/fail');
});


