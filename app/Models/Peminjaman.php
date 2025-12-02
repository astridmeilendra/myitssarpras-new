<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjamanid';
    public $timestamps = false;

    protected $fillable = [
        'userid',
        'keterangan',
        'dokumen'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    /**
     * Relasi ke Ruangan (belongsTo karena satu peminjaman milik satu ruangan)
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruanganid', 'ruanganid');
    }

    /**
     * Relasi ke Riwayat Status
     */
    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatus::class, 'peminjamanid', 'peminjamanid')
                    ->orderBy('waktu_update', 'desc');
    }

    /**
     * Get status terakhir
     */
    public function statusTerakhir()
    {
        return $this->hasOne(RiwayatStatus::class, 'peminjamanid', 'peminjamanid')
                    ->latest('waktu_update');
    }
}
