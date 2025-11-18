<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-db', function () {
    return DB::table('app_user')->get();
});

//DB Connection
Route::get('/cek-koneksi', function () {
    $peminjaman = DB::table('peminjaman')
        ->join('app_user', 'peminjaman.userid', '=', 'app_user.userid')
        ->select('peminjaman.peminjamanid', 'app_user.nama', 'peminjaman.keterangan', 'peminjaman.dokumen')
        ->get();

    return view('cek-koneksi', ['peminjaman' => $peminjaman]);
});

// Splashscreen
Route::get('/', function () {
    return view('page/auth/splashscreen');
});


// Auth Page
Route::get('/myitssarpras', function () {
    return view('page/auth/auth');
});

// Login Page
Route::get('/login', function () {
    return view('page/auth/login');
});

// Login Page
Route::get('/register', function () {
    return view('page/auth/regisster');
});


Route::get('/signup', function () {
    return view('page/signup/signup');
});

Route::get('/profile', function () {
    return view('page/profile/profile');
});

Route::get('/editprofile', function () {
    return view('page/editprofile/editprofile');
});

Route::get('/signin', function () {
    return view('page/register/signin');
});
