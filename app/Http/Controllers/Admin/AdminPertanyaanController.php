<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KirimPertanyaan;
use App\Models\Jawaban;
use Illuminate\Http\Request;

class AdminPertanyaanController extends Controller
{
    /**
     * Tampilkan halaman daftar semua pertanyaan (untuk admin)
     */
    public function index(Request $request)
    {
        // Mulai query
        $query = KirimPertanyaan::with(['user', 'jawaban']);

        // Filter berdasarkan sifat
        if ($request->has('sifat') && $request->sifat) {
            $query->where('sifat', $request->sifat);
        }

        // Filter berdasarkan status jawaban
        if ($request->has('status') && $request->status) {
            if ($request->status === 'terjawab') {
                $query->whereHas('jawaban');
            } elseif ($request->status === 'menunggu') {
                $query->whereDoesntHave('jawaban');
            }
        }

        // Filter berdasarkan lampiran
        if ($request->has('lampiran') && $request->lampiran) {
            if ($request->lampiran === 'yes') {
                $query->whereNotNull('lampiran');
            } elseif ($request->lampiran === 'no') {
                $query->whereNull('lampiran');
            }
        }

        // Ambil data dengan pagination
        $pertanyaan = $query->orderByDesc('pertanyaanid')->paginate(15);

        return view('admin.pertanyaan.index', compact('pertanyaan'));
    }

    /**
     * Tampilkan halaman detail pertanyaan dan form jawab
     */
    public function show($pertanyaanId)
    {
        // Ambil pertanyaan beserta relasi user dan jawaban
        $pertanyaan = KirimPertanyaan::with(['user', 'jawaban'])
            ->findOrFail($pertanyaanId);

        return view('admin.pertanyaan.show', compact('pertanyaan'));
    }

    /**
     * Simpan jawaban untuk pertanyaan
     */
    public function store(Request $request, $pertanyaanId)
    {
        // Validasi input
        $validated = $request->validate([
            'isi_jawaban' => ['required', 'string', 'max:2000'],
        ]);

        // Cari pertanyaan
        $pertanyaan = KirimPertanyaan::findOrFail($pertanyaanId);

        // Cek apakah sudah ada jawaban sebelumnya
        if ($pertanyaan->jawaban) {
            // Update jawaban yang sudah ada
            $pertanyaan->jawaban->update([
                'isi_jawaban' => $validated['isi_jawaban'],
            ]);
        } else {
            // Buat jawaban baru
            Jawaban::create([
                'pertanyaanid' => $pertanyaanId,
                'isi_jawaban' => $validated['isi_jawaban'],
            ]);
        }

        return redirect()
            ->route('admin.pertanyaan.show', $pertanyaanId)
            ->with('success', 'Jawaban berhasil disimpan!');
    }

    /**
     * Update jawaban yang sudah ada
     */
    public function update(Request $request, $pertanyaanId)
    {
        // Validasi input
        $validated = $request->validate([
            'isi_jawaban' => ['required', 'string', 'max:2000'],
        ]);

        // Cari pertanyaan dan jawaban
        $pertanyaan = KirimPertanyaan::findOrFail($pertanyaanId);
        $jawaban = $pertanyaan->jawaban;

        if (!$jawaban) {
            return redirect()->back()->with('error', 'Jawaban tidak ditemukan.');
        }

        // Update jawaban
        $jawaban->update([
            'isi_jawaban' => $validated['isi_jawaban'],
        ]);

        return redirect()
            ->route('admin.pertanyaan.show', $pertanyaanId)
            ->with('success', 'Jawaban berhasil diperbarui!');
    }

    /**
     * Hapus jawaban
     */
    public function destroy($pertanyaanId)
    {
        // Cari pertanyaan dan jawaban
        $pertanyaan = KirimPertanyaan::findOrFail($pertanyaanId);
        $jawaban = $pertanyaan->jawaban;

        if (!$jawaban) {
            return redirect()->back()->with('error', 'Jawaban tidak ditemukan.');
        }

        // Hapus jawaban
        $jawaban->delete();

        return redirect()
            ->route('admin.pertanyaan.show', $pertanyaanId)
            ->with('success', 'Jawaban berhasil dihapus!');
    }
}
