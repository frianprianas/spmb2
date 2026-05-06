<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirLengkap extends Model
{
    use HasFactory;

    protected $table = 'formulir_lengkap';

    protected $fillable = [
        'calon_siswa_id',
        'nik',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'anak_ke',
        'jumlah_saudara',
        'no_hp_siswa',
        'email_siswa',
        'alamat_lengkap',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'nama_ayah',
        'nik_ayah',
        'pekerjaan_ayah',
        'pendidikan_ayah',
        'penghasilan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'nik_ibu',
        'pekerjaan_ibu',
        'pendidikan_ibu',
        'penghasilan_ibu',
        'no_hp_ibu',
        'nama_wali',
        'hubungan_wali',
        'pekerjaan_wali',
        'no_hp_wali',
        'alamat_wali',
        'npsn_smp',
        'alamat_smp',
        'tahun_lulus',
        'nilai_un',
        'foto',
        'scan_kk',
        'scan_akta',
        'scan_ijazah',
        'prestasi',
        'info_tambahan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer',
        'penghasilan_ayah' => 'decimal:2',
        'penghasilan_ibu' => 'decimal:2',
        'tahun_lulus' => 'integer',
        'nilai_un' => 'decimal:2'
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }
}
