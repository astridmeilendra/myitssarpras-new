<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    // 1. Riwayat Peminjaman (list)
    public function riwayat()
    {
        return view('page.riwayat.riwayat');
    }

    // 2. Detail Peminjaman (dibatalkan)
    public function batal()
    {
        return view('page.riwayat.batal');
    }

    // 3. Detail Dalam Peminjaman
    public function dalam()
    {
        return view('page.riwayat.dalam');
    }

    // 4. Detail Peminjaman Selesai
    public function selesai()
    {
        return view('page.riwayat.selesai');
    }

    // 5. Popup konfirmasi batal
    public function konfirmasi()
    {
        return view('page.riwayat.konfirmasi');
    }

    // 6. Halaman gagal dibatalkan
    public function gagal()
    {
        return view('page.riwayat.fail');
    }
}
