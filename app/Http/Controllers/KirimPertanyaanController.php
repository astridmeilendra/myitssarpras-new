<?php

namespace App\Http\Controllers;

use App\Models\KirimPertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KirimPertanyaanController extends Controller
{
    /**
     * Display the form to create a new pertanyaan
     */
    public function create()
    {
        $pertanyaan = collect();

        if (Auth::check()) {
            $pertanyaan = KirimPertanyaan::where('userid', Auth::id())
                ->with('jawaban')
                ->orderByDesc('pertanyaanid')
                ->get();
        }

        return view('page/kirimpertanyaan/kirimpertanyaan', compact('pertanyaan'));
    }

    /**
     * Store a newly created pertanyaan in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isi_pertanyaan' => 'required|string|max:5000',
            'sifat' => 'required|in:rendah,sedang,tinggi,menengah',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            // Store file to storage/app/public or S3
            $lampiran = $request->file('lampiran')->store('pertanyaan', 'public');
        }

        KirimPertanyaan::create([
            'userid' => Auth::id(),
            'isi_pertanyaan' => $validated['isi_pertanyaan'],
            'sifat' => $validated['sifat'],
            'lampiran' => $lampiran,
        ]);

        return redirect()->route('kirimpertanyaan.create')->with('success', 'Pertanyaan berhasil dikirim!');
    }

    /**
     * Display the specified pertanyaan
     */
    public function show($id)
    {
        $pertanyaan = KirimPertanyaan::findOrFail($id);

        // Check authorization
        if ($pertanyaan->userid !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('page/kirimpertanyaan/detailpertanyaan', compact('pertanyaan'));
    }
}
