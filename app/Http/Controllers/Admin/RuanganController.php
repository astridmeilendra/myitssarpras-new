<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = DB::table('ruangan')->get();
        return view('admin.ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('admin.ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'lokasi_ruangan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'required|integer|min:1',
            'foto' => 'nullable|string',
            'fasilitas' => 'nullable|string',
        ]);

        DB::table('ruangan')->insert([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi_ruangan' => $request->lokasi_ruangan,
            'deskripsi' => $request->deskripsi,
            'kapasitas' => $request->kapasitas,
            'foto' => $request->foto,
            'fasilitas' => $request->fasilitas,
        ]);

        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ruangan = DB::table('ruangan')->where('ruanganid', $id)->first();

        if (!$ruangan) {
            return redirect()->route('admin.ruangan.index')->with('error', 'Ruangan tidak ditemukan.');
        }

        return view('admin.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'lokasi_ruangan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'required|integer|min:1',
            'foto' => 'nullable|string',
            'fasilitas' => 'nullable|string',
        ]);

        DB::table('ruangan')->where('ruanganid', $id)->update([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi_ruangan' => $request->lokasi_ruangan,
            'deskripsi' => $request->deskripsi,
            'kapasitas' => $request->kapasitas,
            'foto' => $request->foto,
            'fasilitas' => $request->fasilitas,
        ]);

        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('ruangan')->where('ruanganid', $id)->delete();
        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil dihapus!');
    }
}
