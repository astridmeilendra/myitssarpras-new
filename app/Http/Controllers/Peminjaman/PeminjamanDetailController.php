<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanDetailController extends Controller
{
    /**
     * Menampilkan detail peminjaman
     */
    public function show(Request $request, $peminjamanId)
    {
        $userId = Auth::id();

        // Ambil detail peminjaman dengan semua informasi terkait
        $peminjaman = DB::table('peminjaman as p')
            ->join('ruangan as r', 'p.ruanganid', '=', 'r.ruanganid')
            ->join('app_user as u', 'p.userid', '=', 'u.userid')
            ->leftJoin('riwayat_status as rs', 'p.peminjamanid', '=', 'rs.peminjamanid')
            ->where('p.peminjamanid', $peminjamanId)
            ->where('p.userid', $userId) // Pastikan user hanya bisa lihat data miliknya
            ->select(
                'p.peminjamanid',
                'p.tanggal',
                'p.nama_shift',
                'p.keterangan',
                'p.dokumen',
                'p.userid',
                'r.ruanganid',
                'r.nama_ruangan',
                'r.lokasi_ruangan',
                'r.kapasitas',
                'r.foto',
                'r.fasilitas',
                'r.deskripsi',
                'u.nama',
                'u.no_telepon',
                'u.email_its',
                'rs.nama_status',
                'rs.waktu_update',
                'rs.keterangan as status_keterangan'
            )
            ->first();

        if (!$peminjaman) {
            return redirect()->route('home')->with('error', 'Peminjaman tidak ditemukan');
        }

        // Ambil riwayat status lengkap
        $riwayatStatus = DB::table('riwayat_status')
            ->where('peminjamanid', $peminjamanId)
            ->orderBy('waktu_update', 'asc')
            ->get();

        // Format foto - ambil foto pertama jika ada multiple links
        $fotoUrl = null;

        if ($peminjaman->foto) {
            // Split foto jika ada multiple links dipisah koma
            $photos = array_filter(array_map('trim', explode(',', $peminjaman->foto)));

            if (!empty($photos)) {
                $firstPhoto = $photos[0];

                if (str_starts_with($firstPhoto, 'http://') || str_starts_with($firstPhoto, 'https://')) {
                    $fotoUrl = $firstPhoto;
                } else {
                    $fotoUrl = asset('storage/' . ltrim($firstPhoto, '/'));
                }
            }
        }

        // Format dokumen URL untuk akses
        $dokumenUrl = null;
        if ($peminjaman->dokumen) {
            // Gunakan route download untuk serve dokumen securely
            $dokumenUrl = route('peminjaman.download-dokumen', ['peminjamanid' => $peminjamanId]);
        }

        return view('page.peminjaman.detail', [
            'peminjaman' => $peminjaman,
            'riwayatStatus' => $riwayatStatus,
            'fotoUrl' => $fotoUrl,
            'dokumenUrl' => $dokumenUrl
        ]);
    }

    /**
     * Download dokumen peminjaman
     */
    public function downloadDokumen(Request $request, $peminjamanid)
    {
        $userId = Auth::id();

        // Ambil dokumen path
        $peminjaman = DB::table('peminjaman as p')
            ->where('p.peminjamanid', $peminjamanid)
            ->where('p.userid', $userId) // Security: pastikan user hanya bisa download dokumennya sendiri
            ->select('p.dokumen')
            ->first();

        if (!$peminjaman || !$peminjaman->dokumen) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        $filePath = $peminjaman->dokumen;

        // Parse path - cek apakah file ada
        if (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://')) {
            // Jika URL, redirect ke URL tersebut
            return redirect($filePath);
        }

        // Jika path relatif, konversi ke URL Supabase
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');
        $supabaseBucket = 'dokumen-peminjaman';

        // Konversi path relatif menjadi URL Supabase
        $dokumentUrl = "{$supabaseUrl}/storage/v1/object/public/{$supabaseBucket}/{$filePath}";

        return redirect($dokumentUrl);
    }
}
