<?php

//Imanuel Dwi Prasetyo 5026231114
namespace App\Http\Controllers\Pertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PertanyaanController extends Controller
{
    public function displayPertanyaan()
    {
        $userId = Auth::id();
        $histories = Pertanyaan::with('jawaban')
            ->where('userid', $userId)
            ->orderByDesc('pertanyaanid')
            ->get();

        return view('page.info.kirim-pertanyaan', compact('histories'));
    }

    public function savePertanyaan(Request $request)
    {
        $validated = $request->validate([
            'isi_pertanyaan' => ['required', 'string', 'max:500'],
            'lampiran'       => ['nullable', 'file', 'max:10240'],
            'sifat'          => ['required', 'in:rendah,sedang,menengah'],
        ]);

        $userId = Auth::id();
        $filePath = null;

        // --- UPLOAD MANUAL KE BUCKET 'lampiran'
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            // 1. Bersihkan Nama File
            $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $cleanName;

            // 2. Tentukan Bucket & URL
            // upload langsung ke dalam bucket 'lampiran'
            $bucketName = 'lampiran';

            $supabaseUrl = env('SUPABASE_URL');
            $supabaseKey = env('SUPABASE_SERVICE_ROLE');

            // URL API Supabase untuk Upload
            $uploadUrl = "{$supabaseUrl}/storage/v1/object/{$bucketName}/{$fileName}";

            // 3. Kirim File via HTTP POST
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type'  => $file->getMimeType(),
                ])->withBody(
                    file_get_contents($file->getRealPath()),
                    $file->getMimeType()
                )->post($uploadUrl);

                if ($response->successful()) {
                    // Jika sukses, simpan NAMA FILE-nya di kolom lampiran database
                    $filePath = $fileName;
                } else {
                    return redirect()->back()->with('error', 'Gagal upload ke Supabase: ' . $response->body());
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error koneksi: ' . $e->getMessage());
            }
        }

        // Simpan ke Database
        Pertanyaan::create([
            'userid'         => $userId,
            'isi_pertanyaan' => $validated['isi_pertanyaan'],
            'lampiran'       => $filePath,
            'sifat'          => $validated['sifat'],
        ]);

        // Tampilkan pertanyaan berhasil dikirim
        return view('page.info.pertanyaan-berhasil');
    }
}
