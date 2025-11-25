<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'ruanganid';
    public $timestamps = false;

    protected $fillable = [
        'peminjamanid',
        'nama_ruangan',
        'lokasi_ruangan',
        'deskripsi',
        'kapasitas',
        'foto',
        'fasilitas',
        'nama_shift',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    /**
     * Relasi ke Peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjamanid', 'peminjamanid');
    }

    /**
     * Scope untuk filter ruangan yang tersedia
     */
    public function scopeAvailable($query, $namaRuangan, $tanggal, $shift)
    {
        return $query->whereHas('peminjaman.statusTerakhir', function($q) {
            $q->whereIn('nama_status', ['Menunggu', 'Disetujui']);
        })
        ->where('nama_ruangan', $namaRuangan)
        ->where('tanggal', $tanggal)
        ->where('nama_shift', $shift)
        ->doesntExist();
    }

    /**
     * Get fasilitas as array
     */
    public function getFasilitasArrayAttribute()
    {
        return $this->fasilitas ? explode(',', $this->fasilitas) : [];
    }
}
