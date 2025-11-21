<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Peminjaman\PeminjamanController;

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
Route::get('/loginpage', function () {
    return view('page/loginpage/signin');
});
// Signup Page
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

// ====== RUANGAN & PEMINJAMAN ROUTES ======

// Detail Ruangan (Static - route lama)
Route::get('/ruangan', function () {
    return view('page/ruangan/detail-ruangan');
})->name('ruangan.static');

// Detail Ruangan (Dynamic - route baru dengan ID)
Route::get('/ruangan/{id}', [PeminjamanController::class, 'show'])
    ->name('ruangan.detail');

// ====== PEMINJAMAN ROUTES (Requires Auth) ======
Route::middleware(['auth'])->group(function () {

    // Submit Pengajuan Peminjaman
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');

    // Check Ketersediaan Ruangan (Real-time via AJAX)
    Route::post('/peminjaman/check-availability', [PeminjamanController::class, 'checkAvailability'])
        ->name('peminjaman.check-availability');

    // Halaman Success Peminjaman
    Route::get('/success', function () {
        return view('page/peminjaman/success');
    })->name('peminjaman.success');

});


// // Ruangan
// Route::get('/ruangan', function () {
//     return view('page/ruangan/detail-ruangan');
// });

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
