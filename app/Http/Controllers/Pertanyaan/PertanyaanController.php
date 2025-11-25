<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function index()
    {
        // user yang sedang login
        $userId = Auth::id();

        // ambil pertanyaan user + jawabannya (kalau sudah ada)
        $histories = DB::table('pertanyaan as p')
            ->leftJoin('jawaban as j', 'p.pertanyaanid', '=', 'j.pertanyaanid')
            ->where('p.userid', $userId)
            ->orderBy('p.pertanyaanid', 'desc')
            ->get([
                'p.pertanyaanid',
                'p.isi_pertanyaan',
                'p.lampiran',
                'p.sifat',
                'j.isi_jawaban'
            ]);

        return view('page.info.kirim-pertanyaan', compact('histories'));
    }

    public function store(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'isi_pertanyaan' => 'required|string|max:500',
            'lampiran' => 'nullable|file|max:10240', // max 10MB
            'sifat' => 'required|in:rendah,sedang,menengah'
        ]);

        $userId = Auth::id();

        // handle file upload
        $filePath = null;
        if ($request->hasFile('lampiran')) {
            $filePath = $request->file('lampiran')->store('pertanyaan', 'public');
        }

        // create pertanyaan
        Pertanyaan::create([
            'userid' => $userId,
            'isi_pertanyaan' => $validated['isi_pertanyaan'],
            'lampiran' => $filePath,
            'sifat' => $validated['sifat']
        ]);

        return redirect()->route('kirim-pertanyaan')->with('success', 'Pertanyaan berhasil dikirim!');
    }
}
