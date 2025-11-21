<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function show($ruanganId)
    {
        $ruangan = DB::table('ruangan')
            ->where('ruanganid', $ruanganId)
            ->first();

        if (!$ruangan) {
            abort(404, 'Ruangan tidak ditemukan');
        }

        $jadwalTerpakai = DB::table('peminjaman as p')
            ->join('riwayat_status as rs', function ($join) {
                $join->on('p.peminjamanid', '=', 'rs.peminjamanid')
                    ->whereRaw('rs.statusid = (
                        SELECT MAX(statusid)
                        FROM riwayat_status
                        WHERE peminjamanid = p.peminjamanid
                    )');
            })
            ->where('p.ruanganid', $ruanganId)
            ->where('rs.nama_status', '!=', 'Ditolak')
            ->where('p.tanggal', '>=', now()->toDateString())
            ->select('p.tanggal', 'p.nama_shift')
            ->get();

        return view('page.ruangan.detail-ruangan', compact('ruangan', 'jadwalTerpakai'));
    }

    public function store(Request $request)
    {
        // Middleware auth sudah ada, ini cuma extra guard
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu',
            ], 401);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'ruangan_id'  => 'required|integer|exists:ruangan,ruanganid',
            'tanggal'     => 'required|date|after:today',
            'waktu'       => 'required|string|in:sesi1,sesi2,sesi3,sesi4',
            'keterangan'  => 'required|string|max:1000',
            'dokumen'     => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ], [
            'tanggal.after' => 'Tanggal peminjaman harus setelah hari ini',
            'waktu.in'      => 'Waktu yang dipilih tidak valid',
            'dokumen.max'   => 'Ukuran file maksimal 5MB',
            'dokumen.mimes' => 'Format file harus PDF, DOC, DOCX, JPG, JPEG, atau PNG',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $userId = Auth::id();

        // Mapping waktu ke nama shift
        $shiftMapping = [
            'sesi1' => 'Sesi 1 (07.00 - 10.00)',
            'sesi2' => 'Sesi 2 (10.15 - 12.45)',
            'sesi3' => 'Sesi 3 (13.30 - 16.00)',
            'sesi4' => 'Sesi 4 (16.00 - 18.30)',
        ];

        $namaShift = $shiftMapping[$request->waktu];

        // Cek ketersediaan: apakah sudah ada booking aktif dengan kombinasi ini
        $sudahDipinjam = DB::table('peminjaman as p')
            ->join('riwayat_status as rs', function ($join) {
                $join->on('p.peminjamanid', '=', 'rs.peminjamanid')
                    ->whereRaw('rs.statusid = (
                        SELECT MAX(statusid)
                        FROM riwayat_status
                        WHERE peminjamanid = p.peminjamanid
                    )');
            })
            ->where('p.ruanganid', $request->ruangan_id)
            ->where('p.tanggal', $request->tanggal)
            ->where('p.nama_shift', $namaShift)
            ->whereIn('rs.nama_status', ['Menunggu', 'Disetujui'])
            ->exists();

        if ($sudahDipinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan sudah dipinjam pada tanggal dan waktu tersebut',
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

            // Insert ke tabel peminjaman (1 record = 1 booking)
            $peminjamanId = DB::table('peminjaman')->insertGetId([
                'userid'     => $userId,
                'ruanganid'  => $request->ruangan_id,
                'tanggal'    => $request->tanggal,
                'nama_shift' => $namaShift,
                'keterangan' => $request->keterangan,
                'dokumen'    => $dokumenPath,
            ], 'peminjamanid');


            // Insert status awal ke tabel riwayat_status
            DB::table('riwayat_status')->insert([
                'peminjamanid' => $peminjamanId,
                'nama_status'  => 'Menunggu',
                'waktu_update' => now(),
                'keterangan'   => 'Pengajuan peminjaman ruangan baru',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diajukan',
                'data' => [
                    'peminjaman_id' => $peminjamanId,
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            if (!empty($dokumenPath) && Storage::disk('public')->exists($dokumenPath)) {
                Storage::disk('public')->delete($dokumenPath);
            }

            Log::error('Peminjaman store error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses peminjaman',
                'error'   => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    public function checkAvailability(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'ruangan_id' => 'required|integer|exists:ruangan,ruanganid',
            'tanggal'    => 'required|date',
            'waktu'      => 'required|string|in:sesi1,sesi2,sesi3,sesi4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $shiftMapping = [
            'sesi1' => 'Sesi 1 (07.00 - 10.00)',
            'sesi2' => 'Sesi 2 (10.15 - 12.45)',
            'sesi3' => 'Sesi 3 (13.30 - 16.00)',
            'sesi4' => 'Sesi 4 (16.00 - 18.30)',
        ];

        $namaShift = $shiftMapping[$request->waktu];

        $available = !DB::table('peminjaman as p')
            ->join('riwayat_status as rs', function ($join) {
                $join->on('p.peminjamanid', '=', 'rs.peminjamanid')
                    ->whereRaw('rs.statusid = (
                        SELECT MAX(statusid)
                        FROM riwayat_status
                        WHERE peminjamanid = p.peminjamanid
                    )');
            })
            ->where('p.ruanganid', $request->ruangan_id)
            ->where('p.tanggal', $request->tanggal)
            ->where('p.nama_shift', $namaShift)
            ->whereIn('rs.nama_status', ['Menunggu', 'Disetujui'])
            ->exists();

        return response()->json([
            'success'   => true,
            'available' => $available,
        ]);
    }

    public function getAvailableSlots(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'ruangan_id' => 'required|integer|exists:ruangan,ruanganid',
            'tanggal'    => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Mapping sesi → label shift (sama seperti di store())
        $shiftMapping = [
            'sesi1' => 'Sesi 1 (07.00 - 10.00)',
            'sesi2' => 'Sesi 2 (10.15 - 12.45)',
            'sesi3' => 'Sesi 3 (13.30 - 16.00)',
            'sesi4' => 'Sesi 4 (16.00 - 18.30)',
        ];

        // Ambil semua shift yang sudah dibooking untuk ruangan + tanggal itu
        $bookedShifts = DB::table('peminjaman as p')
            ->join('riwayat_status as rs', function ($join) {
                $join->on('p.peminjamanid', '=', 'rs.peminjamanid')
                    ->whereRaw('rs.statusid = (
                        SELECT MAX(statusid)
                        FROM riwayat_status
                        WHERE peminjamanid = p.peminjamanid
                    )');
            })
            ->where('p.ruanganid', $request->ruangan_id)
            ->where('p.tanggal', $request->tanggal)
            ->whereIn('rs.nama_status', ['Menunggu', 'Disetujui'])
            ->pluck('p.nama_shift')
            ->toArray();

        // Bangun array slot: true = tersedia, false = penuh
        $slots = [];
        foreach ($shiftMapping as $key => $label) {
            $slots[$key] = !in_array($label, $bookedShifts);
        }

        return response()->json([
            'success' => true,
            'slots'   => $slots,
        ]);
    }
}
