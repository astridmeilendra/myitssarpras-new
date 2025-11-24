<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = DB::table('peminjaman as p')
            ->join('ruangan as r', 'p.ruanganid', '=', 'r.ruanganid')
            ->join('app_user as u', 'p.userid', '=', 'u.userid')
            ->join('riwayat_status as rs', function ($join) {
                $join->on('p.peminjamanid', '=', 'rs.peminjamanid')
                     ->whereRaw('rs.statusid = (
                         SELECT MAX(statusid)
                         FROM riwayat_status
                         WHERE peminjamanid = p.peminjamanid
                     )');
            });

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('rs.nama_status', $request->status);
        }

        // Filter by room
        if ($request->has('ruangan') && $request->ruangan != '') {
            $query->where('r.nama_ruangan', 'like', '%' . $request->ruangan . '%');
        }

        // Filter by shift/session
        if ($request->has('sesi') && $request->sesi != '') {
            $query->where('p.nama_shift', $request->sesi);
        }

        // Sorting
        $sortBy = $request->get('sort', 'tanggal');
        $sortDir = $request->get('dir', 'desc');

        switch ($sortBy) {
            case 'status':
                $query->orderBy('rs.nama_status', $sortDir);
                break;
            case 'ruangan':
                $query->orderBy('r.nama_ruangan', $sortDir);
                break;
            case 'sesi':
                $query->orderBy('p.nama_shift', $sortDir);
                break;
            default:
                $query->orderBy('p.tanggal', $sortDir);
        }

        $query->orderBy('p.peminjamanid', 'desc');

        $peminjaman = $query->select(
            'p.peminjamanid',
            'p.tanggal',
            'p.nama_shift',
            'p.keterangan as keterangan_peminjaman',
            'r.nama_ruangan',
            'u.nama as nama_peminjam',
            'rs.nama_status',
            'rs.keterangan as keterangan_status'
        )->get();

        // Get unique values for filter dropdowns
        $statuses = DB::table('riwayat_status')->distinct()->pluck('nama_status');
        $ruangan = DB::table('ruangan')->distinct()->pluck('nama_ruangan');
        $sesi = DB::table('peminjaman')->distinct()->pluck('nama_shift');

        return view('admin.dashboard', compact('peminjaman', 'statuses', 'ruangan', 'sesi'));
    }

    public function updateStatus(Request $request, $peminjamanId)
    {
        $request->validate([
            'status' => 'required|string|in:Disetujui,Ditolak,Revisi',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Cek apakah peminjaman ada
        $peminjaman = DB::table('peminjaman')->where('peminjamanid', $peminjamanId)->first();
        if (!$peminjaman) {
            return back()->with('error', 'Peminjaman tidak ditemukan.');
        }

        // Insert status baru
        DB::table('riwayat_status')->insert([
            'peminjamanid' => $peminjamanId,
            'nama_status'  => $request->status,
            'waktu_update' => now(),
            'keterangan'   => $request->keterangan,
        ]);

        return back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}
