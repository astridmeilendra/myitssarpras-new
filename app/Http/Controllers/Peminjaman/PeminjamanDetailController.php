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

        // Ambil status terakhir dulu
        $statusTerakhir = DB::table('riwayat_status')
            ->where('peminjamanid', $peminjamanId)
            ->orderBy('statusid', 'desc')
            ->first();

        $status = $statusTerakhir?->nama_status ?? 'Menunggu';

        // Ambil detail peminjaman dengan informasi terkait
        $peminjaman = DB::table('peminjaman as p')
            ->join('ruangan as r', 'p.ruanganid', '=', 'r.ruanganid')
            ->join('app_user as u', 'p.userid', '=', 'u.userid')
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
                'u.email_its'
            )
            ->first();

        if (!$peminjaman) {
            return redirect()->route('home')->with('error', 'Peminjaman tidak ditemukan');
        }

        // Ambil riwayat status lengkap
        $riwayatStatus = DB::table('riwayat_status')
            ->where('peminjamanid', $peminjamanId)
            ->orderBy('statusid', 'asc')
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

        // Selalu gunakan view yang sama, cukup pass status ke view
        return view('page.peminjaman.detail-peminjaman', [
            'peminjaman' => $peminjaman,
            'riwayatStatus' => $riwayatStatus,
            'statusTerakhir' => $status,
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

    /**
     * Batalkan peminjaman
     */
    public function cancel(Request $request, $peminjamanid)
    {
        $userId = Auth::id();

        // Ambil peminjaman dan status terakhir
        $peminjaman = DB::table('peminjaman')
            ->where('peminjamanid', $peminjamanid)
            ->where('userid', $userId) // Security: pastikan user hanya bisa batalkan miliknya
            ->first();

        if (!$peminjaman) {
            return redirect()->route('riwayat')->with('error', 'Peminjaman tidak ditemukan');
        }

        // Cek status terakhir - hanya bisa batalkan jika masih "Menunggu"
        $statusTerakhir = DB::table('riwayat_status')
            ->where('peminjamanid', $peminjamanid)
            ->orderBy('statusid', 'desc')
            ->first();

        $status = $statusTerakhir?->nama_status ?? 'Menunggu';

        if ($status !== 'Menunggu') {
            return redirect()->route('peminjaman.detail', $peminjamanid)
                ->with('error', 'Hanya peminjaman dengan status Menunggu yang dapat dibatalkan');
        }

        // Buat riwayat status baru dengan status "Dibatalkan"
        DB::table('riwayat_status')->insert([
            'peminjamanid' => $peminjamanid,
            'nama_status' => 'Dibatalkan',
            'waktu_update' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('peminjaman.detail', $peminjamanid)
            ->with('success', 'Peminjaman berhasil dibatalkan');
    }
}
