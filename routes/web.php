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
