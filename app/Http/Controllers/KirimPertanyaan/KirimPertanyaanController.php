<?php

namespace App\Http\Controllers\KirimPertanyaan;

use App\Http\Controllers\Controller;
use App\Models\KirimPertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KirimPertanyaanController extends Controller
{
    /**
     * Show the form for creating a new resource and display user's questions.
     */
    public function create()
    {
        // Ambil pertanyaan milik user yang sedang login
        $pertanyaan = collect(); // Default empty collection
        
        if (Auth::check()) {
            $pertanyaan = KirimPertanyaan::where('userid', Auth::id())
                ->with('jawaban') // Eager load jawaban
                ->orderBy('pertanyaanid', 'desc')
                ->get();
        }
        
        return view('page.kirimpertanyaan.kirimpertanyaan', compact('pertanyaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'isi_pertanyaan' => 'required|string|max:500',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
            'sifat' => 'required|in:rendah,sedang,tinggi'
        ], [
            'isi_pertanyaan.required' => 'Pertanyaan wajib diisi',
            'isi_pertanyaan.max' => 'Pertanyaan maksimal 500 karakter',
            'lampiran.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG',
            'lampiran.max' => 'Ukuran file maksimal 5MB',
            'sifat.required' => 'Sifat pertanyaan wajib dipilih',
        ]);

        // Prepare data
        $data = [
            'isi_pertanyaan' => $validated['isi_pertanyaan'],
            'sifat' => $validated['sifat'],
            'lampiran' => null
        ];

        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda harus login terlebih dahulu untuk mengirim pertanyaan.');
        }

        $data['userid'] = Auth::id();

        // Handle file upload
        if ($request->hasFile('lampiran')) {
            try {
                $file = $request->file('lampiran');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                
                // Simpan file ke storage/app/public/lampiran
                $path = $file->storeAs('lampiran', $filename, 'public');
                $data['lampiran'] = $path;
                
                \Log::info('File uploaded:', ['path' => $path]);
            } catch (\Exception $e) {
                \Log::error('File upload error:', ['message' => $e->getMessage()]);
            }
        }

        // Simpan ke database
        try {
            $pertanyaan = KirimPertanyaan::create($data);
            
            \Log::info('Data saved successfully:', ['id' => $pertanyaan->pertanyaanid]);
            
            return redirect()->route('kirimpertanyaan.create')
                ->with('success', 'Pertanyaan berhasil dikirim!');
                
        } catch (\Exception $e) {
            \Log::error('Database error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengirim pertanyaan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pertanyaan = KirimPertanyaan::with('jawaban')->findOrFail($id);
        
        // Pastikan user hanya bisa melihat pertanyaannya sendiri
        if (Auth::check() && $pertanyaan->userid !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('page.kirimpertanyaan.detailpertanyaan', compact('pertanyaan'));
    }
}