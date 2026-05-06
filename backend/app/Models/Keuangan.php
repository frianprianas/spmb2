<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Keuangan extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'keuangan';

    protected $fillable = [
        'username',
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
