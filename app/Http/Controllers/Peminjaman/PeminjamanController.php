<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    /**
     * Tampilkan halaman detail ruangan
     */
    public function show($ruanganId)
    {
        // Ambil data ruangan dari database (untuk display info ruangan)
        $ruangan = DB::table('ruangan')
            ->where('ruanganid', $ruanganId)
            ->first();

        if (!$ruangan) {
            abort(404, 'Ruangan tidak ditemukan');
        }

        // Ambil jadwal peminjaman yang sudah ada untuk ruangan ini
        $jadwalTerpakai = DB::table('ruangan as r')
            ->join('peminjaman as p', 'r.peminjamanid', '=', 'p.peminjamanid')
            ->join('riwayat_status as rs', 'p.peminjamanid', '=', 'rs.peminjamanid')
            ->where('r.nama_ruangan', $ruangan->nama_ruangan)
            ->where('rs.nama_status', '!=', 'Ditolak')
            ->where('r.tanggal', '>=', now()->toDateString())
            ->select('r.tanggal', 'r.nama_shift')
            ->get();

        return view('page.ruangan.detail-ruangan', compact('ruangan', 'jadwalTerpakai'));
    }

    /**
     * Proses pengajuan peminjaman ruangan
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_ruangan' => 'required|string|max:100',
            'tanggal' => 'required|date|after:today',
            'waktu' => 'required|string|in:sesi1,sesi2,sesi3,sesi4',
            'keterangan' => 'required|string|max:1000',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120' // max 5MB
        ], [
            'tanggal.after' => 'Tanggal peminjaman harus setelah hari ini',
            'waktu.in' => 'Waktu yang dipilih tidak valid',
            'dokumen.max' => 'Ukuran file maksimal 5MB',
            'dokumen.mimes' => 'Format file harus PDF, DOC, DOCX, JPG, JPEG, atau PNG'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah user sudah login
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu'
            ], 401);
        }

        $userId = Auth::id();

        // Mapping waktu ke nama shift
        $shiftMapping = [
            'sesi1' => 'Sesi 1 (07.00 - 10.00)',
            'sesi2' => 'Sesi 2 (10.15 - 12.45)',
            'sesi3' => 'Sesi 3 (13.30 - 16.00)',
            'sesi4' => 'Sesi 4 (16.00 - 18.30)'
        ];

        $namaShift = $shiftMapping[$request->waktu];

        // Cek ketersediaan ruangan pada tanggal dan waktu yang dipilih
        $sudahDipinjam = DB::table('ruangan as r')
            ->join('peminjaman as p', 'r.peminjamanid', '=', 'p.peminjamanid')
            ->join('riwayat_status as rs', function($join) {
                $join->on('p.peminjamanid', '=', 'rs.peminjamanid')
                     ->whereRaw('rs.statusid = (
                         SELECT MAX(statusid)
                         FROM riwayat_status
                         WHERE peminjamanid = p.peminjamanid
                     )');
            })
            ->where('r.nama_ruangan', $request->nama_ruangan)
            ->where('r.tanggal', $request->tanggal)
            ->where('r.nama_shift', $namaShift)
            ->whereIn('rs.nama_status', ['Menunggu', 'Disetujui'])
            ->exists();

        if ($sudahDipinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan sudah dipinjam pada tanggal dan waktu tersebut'
            ], 409);
        }

        DB::beginTransaction();

        try {
            // Upload dokumen jika ada
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                $file = $request->file('dokumen');
                $filename = time() . '_' . $file->getClientOriginalName();
                $dokumenPath = $file->storeAs('dokumen_peminjaman', $filename, 'public');
            }

            // Insert ke tabel peminjaman
            $peminjamanId = DB::table('peminjaman')->insertGetId([
                'userid' => $userId,
                'keterangan' => $request->keterangan,
                'dokumen' => $dokumenPath
            ]);

            // Ambil data ruangan master untuk mendapatkan detail lengkap
            $ruanganMaster = DB::table('ruangan')
                ->where('nama_ruangan', $request->nama_ruangan)
                ->first();

            // Insert ke tabel ruangan (detail peminjaman)
            DB::table('ruangan')->insert([
                'peminjamanid' => $peminjamanId,
                'nama_ruangan' => $request->nama_ruangan,
                'lokasi_ruangan' => $ruanganMaster->lokasi_ruangan ?? null,
                'deskripsi' => $ruanganMaster->deskripsi ?? null,
                'kapasitas' => $ruanganMaster->kapasitas ?? null,
                'foto' => $ruanganMaster->foto ?? null,
                'fasilitas' => $ruanganMaster->fasilitas ?? null,
                'nama_shift' => $namaShift,
                'tanggal' => $request->tanggal
            ]);

            // Insert status awal ke tabel riwayat_status
            DB::table('riwayat_status')->insert([
                'peminjamanid' => $peminjamanId,
                'nama_status' => 'Menunggu',
                'waktu_update' => now(),
                'keterangan' => 'Pengajuan peminjaman ruangan baru'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diajukan',
                'data' => [
                    'peminjaman_id' => $peminjamanId
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sudah diupload jika terjadi error
            if ($dokumenPath && Storage::disk('public')->exists($dokumenPath)) {
                Storage::disk('public')->delete($dokumenPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses peminjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cek ketersediaan ruangan
     */
    public function checkAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruangan' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $shiftMapping = [
            'sesi1' => 'Sesi 1 (07.00 - 10.00)',
            'sesi2' => 'Sesi 2 (10.15 - 12.45)',
            'sesi3' => 'Sesi 3 (13.30 - 16.00)',
            'sesi4' => 'Sesi 4 (16.00 - 18.30)'
        ];

        $namaShift = $shiftMapping[$request->waktu];

        $available = !DB::table('ruangan as r')
            ->join('peminjaman as p', 'r.peminjamanid', '=', 'p.peminjamanid')
            ->join('riwayat_status as rs', function($join) {
                $join->on('p.peminjamanid', '=', 'rs.peminjamanid')
                     ->whereRaw('rs.statusid = (
                         SELECT MAX(statusid)
                         FROM riwayat_status
                         WHERE peminjamanid = p.peminjamanid
                     )');
            })
            ->where('r.nama_ruangan', $request->nama_ruangan)
            ->where('r.tanggal', $request->tanggal)
            ->where('r.nama_shift', $namaShift)
            ->whereIn('rs.nama_status', ['Menunggu', 'Disetujui'])
            ->exists();

        return response()->json([
            'success' => true,
            'available' => $available
        ]);
    }
}
