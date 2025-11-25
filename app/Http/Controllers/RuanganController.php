<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        // ambil data (ubah sesuai strukturmu)
        $rooms = Ruangan::latest()->take(10)->get();   // atau Ruangan::all();

        // sesuaikan path view dengan punyamu:
        // resources/views/page/cariruangan/cariruanganparsial.blade.php
        return view('page.cariruangan.cariruanganparsial', compact('rooms'));
        $rooms = collect(); // atau []
        dd($rooms);
    }
}
