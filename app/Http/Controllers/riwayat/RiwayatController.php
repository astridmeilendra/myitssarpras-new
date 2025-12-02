<?php

namespace App\Http\Controllers\Riwayat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class RiwayatController extends Controller
{
    // 1. Riwayat Peminjaman (list)
    public function riwayat()
    {
        // Ambil user yang login
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil semua peminjaman user dengan relasi ruangan dan status terbaru
        $peminjamans = Peminjaman::where('userid', $user->userid)
            ->with(['ruangan', 'statusTerakhir'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('page.riwayat.riwayat', compact('peminjamans'));
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
