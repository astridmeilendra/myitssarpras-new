<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Navbar
Route::get('/home', function () {
    return view('page/homepage');
})->name('home');

Route::get('/riwayat', function () {
    return view('riwayat');
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

// Auth
Route::get('/', function () {
    return view('page/auth/auth');
});

// Login Page
Route::get('/login', function () {
    return view('page/auth/login');
});

// Register Page
Route::get('/register', function () {
    return view('page/register/signin');
});


Route::get('/alur-penjelasan', function () {
    return view('alur-penjelasan', ['title' => 'Alur Penjelasan']);
});

Route::get('/faq', function () {
    return view('faq', ['title' => 'FAQ']);
});

Route::get('/kirim-pertanyaan', function () {
    return view('kirim-pertanyaan', ['title' => 'Kirim Pertanyaan']);
});
=======
Route::get('/signup', function () {
    return view('page/signup/signup');
});

Route::get('/editprofile', function () {
    return view('page/editprofile/editprofile');
});

Route::get('/signin', function () {
    return view('page/register/signin');
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




// Cariruangan
Route::get('/cariruangan', function () {
    return view('page/cariruangan/cariruangan');
});

//Cariruangan parsial
Route::get('/cariruanganparsial', function () {
    return view('page/cariruangan/cariruanganparsial');
});