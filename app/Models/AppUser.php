<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AppUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'app_user';
    protected $primaryKey = 'userid';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email_its',
        'password_hash',
        'no_telepon',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
