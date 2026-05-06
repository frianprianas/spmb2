<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CalonSiswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'calon_siswa';

    protected $fillable = [
        'no_pendaftaran',
        'nisn',
        'nama',
        'alamat',
        'jenis_kelamin',
        'asal_smp',
        'jurusan_id',
        'email',
        'no_hp',
        'status_pembayaran',
        'status_formulir',
        'status_pendaftaran',
        'password',
        'verification_token',
        'verification_token_expires_at',
        'is_verified',
        'file_kk',
        'status_upload_kk',
        'status_pembayaran',
        'snap_token_pembayaran'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function formulirLengkap()
    {
        return $this->hasOne(FormulirLengkap::class);
    }

    /**
     * Generate nomor pendaftaran unik
     */
    public static function generateNoPendaftaran()
    {
        $year = date('Y');
        $lastNumber = self::whereYear('created_at', $year)
            ->max('no_pendaftaran');

        if ($lastNumber) {
            $lastNumber = (int) substr($lastNumber, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'SPMB' . $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
