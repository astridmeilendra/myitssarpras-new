<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    protected $table = 'riwayat_status';
    protected $primaryKey = 'statusid';
    public $timestamps = false;

    protected $fillable = [
        'peminjamanid',
        'nama_status',
        'waktu_update',
        'keterangan'
    ];

    protected $casts = [
        'waktu_update' => 'datetime'
    ];

    /**
     * Relasi ke Peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjamanid', 'peminjamanid');
    }

    /**
     * Scope untuk status tertentu
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('nama_status', $status);
    }

    /**
     * Check if status is approved
     */
    public function isApproved()
    {
        return $this->nama_status === 'Disetujui';
    }

    /**
     * Check if status is pending
     */
    public function isPending()
    {
        return $this->nama_status === 'Menunggu';
    }

    /**
     * Check if status is rejected
     */
    public function isRejected()
    {
        return $this->nama_status === 'Ditolak';
    }
}
