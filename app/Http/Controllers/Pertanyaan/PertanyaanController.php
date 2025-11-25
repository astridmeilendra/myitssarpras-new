<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PertanyaanController extends Controller
{
    /**
     * Tampilkan halaman "Kirim Pertanyaan"
     * beserta daftar pertanyaan milik user yang sedang login.
     */
    public function index()
    {
        // Pastikan user sudah login (harusnya sudah lewat middleware auth)
        $userId = Auth::id();

        // Ambil semua pertanyaan milik user + relasi jawaban (jika ada)
        $histories = Pertanyaan::with('jawaban')
            ->where('userid', $userId)
            ->orderByDesc('pertanyaanid')
            ->get();

        return view('page.info.kirim-pertanyaan', compact('histories'));
    }

    /**
     * Simpan pertanyaan baru dari user.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'isi_pertanyaan' => ['required', 'string', 'max:500'],
            'lampiran'       => ['nullable', 'file', 'max:10240'], // max 10 MB
            'sifat'          => ['required', 'in:rendah,sedang,menengah'],
        ]);

        $userId = Auth::id();

        // Default: tidak ada file
        $filePath = null;

        // Kalau ada lampiran, upload ke Supabase Storage (disk: supabase)
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            // Nama file unik biar tidak tabrakan
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Folder di dalam bucket (misal: dokumen-pertanyaan/lampiran/xxx.pdf)
            $filePath = 'lampiran/' . $fileName;

            // Simpan ke disk 'supabase' (sudah di-setup di config/filesystems.php)
            Storage::disk('supabase')->put(
                $filePath,
                file_get_contents($file->getRealPath())
            );
        }

        // Simpan ke tabel pertanyaan
        Pertanyaan::create([
            'userid'         => $userId,
            'isi_pertanyaan' => $validated['isi_pertanyaan'],
            'lampiran'       => $filePath, // path di Supabase
            'sifat'          => $validated['sifat'],
        ]);

        return redirect()
            ->route('kirim-pertanyaan')
            ->with('success', 'Pertanyaan berhasil dikirim!');
    }
}