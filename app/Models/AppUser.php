<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    // Nama tabel di database
    protected $table = 'app_user';

    // Primary key
    protected $primaryKey = 'userid';

    // Tabel app_user tidak punya created_at & updated_at
    public $timestamps = false;

    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'nama',
        'email_its',
        'password_hash',
        'no_telepon',   // <- ini yang dipakai
    ];
}
