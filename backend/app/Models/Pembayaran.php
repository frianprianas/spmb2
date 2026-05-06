<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'calon_siswa_id',
        'no_pembayaran',
        'jumlah',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
        'tanggal_bayar',
        'tanggal_verifikasi',
        'catatan'
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
        'tanggal_verifikasi' => 'datetime'
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }

    /**
     * Generate nomor pembayaran unik
     */
    public static function generateNoPembayaran()
    {
        $year = date('Y');
        $month = date('m');
        $lastNumber = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->max('no_pembayaran');

        if ($lastNumber) {
            $lastNumber = (int) substr($lastNumber, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'PAY' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
