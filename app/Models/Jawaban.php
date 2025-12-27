<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban';
    protected $primaryKey = 'jawabanid';
    public $timestamps = false;

    protected $fillable = [
        'pertanyaanid',
        'isi_jawaban',
    ];

    /**
     * Pertanyaan yang dijawab.
     */
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaanid', 'pertanyaanid');
    }
}