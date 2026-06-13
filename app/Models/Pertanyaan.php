<?php

//Imanuel Dwi Prasetyo 5026231114
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';
    protected $primaryKey = 'pertanyaanid';
    public $timestamps = false;

    protected $fillable = [
        'userid',
        'isi_pertanyaan',
        'lampiran',
        'sifat',
    ];

    /**
     * User yang membuat pertanyaan.
     */
    public function user()
    {
    return $this->belongsTo(AppUser::class, 'userid', 'userid');
    }

    /**
     * Jawaban untuk pertanyaan ini (0 atau 1).
     */
    public function jawaban()
    {
        return $this->hasOne(Jawaban::class, 'pertanyaanid', 'pertanyaanid');
    }
}
