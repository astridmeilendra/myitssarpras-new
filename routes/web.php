<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
    return view('page/info/alur-penjelasan');
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

// Auth
Route::get('/', function () {
    return view('page/auth/auth');
});

// Login Page
Route::get('/login', function () {
    return view('page/auth/login');
});

// Register Page
Route::get('/loginpage', function () {
    return view('page/loginpage/signin');
});


Route::get('/alur-penjelasan', function () {
    return view('page/info/alur-penjelasan', ['title' => 'Alur Penjelasan']);
});

Route::get('/faq', function () {
    return view('page/info/faq', ['title' => 'FAQ']);
});

Route::get('/kirim-pertanyaan', function () {
    return view('page/info/kirim-pertanyaan', ['title' => 'Kirim Pertanyaan']);
});

Route::get('/signup', function () {
    return view('page/signup/signup');
});

Route::get('/editakun', function () {
    return view('page/editprofile/editakun');
});

Route::get('/signin', function () {
    return view('page/loginpage/signin');
});
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

// Cariruangan
Route::get('/cariruangan', function () {
    return view('page/cariruangan/cariruangan');
});

//Cariruangan parsial
Route::get('/cariruanganparsial', function () {
    return view('page/cariruangan/cariruanganparsial');
});