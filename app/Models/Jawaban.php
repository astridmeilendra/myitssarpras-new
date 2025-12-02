<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jawaban';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'jawabanid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pertanyaanid',
        'isi_jawaban',
        'admin_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pertanyaanid' => 'integer',
        'jawabanid' => 'integer',
        'admin_id' => 'integer',
    ];

    /**
     * Get the pertanyaan that owns the jawaban.
     */
    public function pertanyaan()
    {
        return $this->belongsTo(KirimPertanyaan::class, 'pertanyaanid', 'pertanyaanid');
    }
}