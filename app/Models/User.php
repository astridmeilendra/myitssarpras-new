<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'app_user';
    protected $primaryKey = 'userid';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'nrp',
        'email_its',
        'password_hash',
        'prodi',
        'foto_profile',
        'no_telepon'
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Relasi ke Peminjaman
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'userid', 'userid');
    }

    /**
     * Override getAuthPassword untuk Laravel Auth
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
