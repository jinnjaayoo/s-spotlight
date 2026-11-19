<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Loginadmin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';  // sumber data akun

    protected $fillable = [
        'name',
        'email',
        'password',     
        'foto',
        'keterangan',
    ];

    protected $hidden = [  // pass dan remember token di sembunyikan dari representasi model
        'password',
        'remember_token',
    ];

    protected $casts = [  // pass menggunakan hashing
        'password' => 'hashed',
    ];
}
