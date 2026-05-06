<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'deskripsi',
        'kuota',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'kuota' => 'integer'
    ];

    public function calonSiswa()
    {
        return $this->hasMany(CalonSiswa::class);
    }
}
