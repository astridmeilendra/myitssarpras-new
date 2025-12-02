<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $lampiran = null;

        // Kalau ada lampiran, upload ke Supabase Storage via API
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            // Nama file unik biar tidak tabrakan
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Path di dalam bucket dokumen-pertanyaan
            $filePath = 'pertanyaan/' . $userId . '/' . $fileName;

            // Ambil Supabase credentials dari env
            $supabaseUrl = env('SUPABASE_URL');
            $supabaseBucket = 'dokumen-pertanyaan';
            $supabaseServiceKey = env('SUPABASE_SERVICE_ROLE');

            // Upload file ke Supabase via REST API
            $fileContent = file_get_contents($file->getRealPath());
            $response = \Http::withHeaders([
                'Authorization' => 'Bearer ' . $supabaseServiceKey,
                'Content-Type'  => $file->getMimeType(),
            ])->withBody($fileContent, $file->getMimeType())
            ->post("{$supabaseUrl}/storage/v1/object/{$supabaseBucket}/{$filePath}");

            // Jika upload berhasil, simpan URL lengkap ke database
            if ($response->successful()) {
                $lampiran = "{$supabaseUrl}/storage/v1/object/public/{$supabaseBucket}/{$filePath}";
            } else {
                return redirect()->back()->with('error', 'Gagal upload file ke Supabase.');
            }
        }

        // Simpan ke tabel pertanyaan
        Pertanyaan::create([
            'userid'         => $userId,
            'isi_pertanyaan' => $validated['isi_pertanyaan'],
            'lampiran'       => $lampiran, // URL penuh dari Supabase
            'sifat'          => $validated['sifat'],
        ]);

        return redirect()
            ->route('kirim-pertanyaan')
            ->with('success', 'Pertanyaan berhasil dikirim!');
    }
}
