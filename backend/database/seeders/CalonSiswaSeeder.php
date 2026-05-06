<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CalonSiswa;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CalonSiswaSeeder extends Seeder
{
    public function run()
    {
        // Ambil jurusan pertama
        $jurusan = Jurusan::first();
        
        if (!$jurusan) {
            $this->command->error('Tidak ada jurusan! Jalankan JurusanSeeder terlebih dahulu.');
            return;
        }

        // Buat 3 calon siswa dummy
        $siswaData = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'no_hp' => '081234567890',
                'asal_smp' => 'SMP Negeri 1 Jakarta',
                'status_pembayaran' => 'belum_bayar',
                'status_formulir' => 'belum_isi',
                'status_pendaftaran' => 'pending',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'no_hp' => '081234567891',
                'asal_smp' => 'SMP Negeri 2 Jakarta',
                'status_pembayaran' => 'verifikasi',
                'status_formulir' => 'belum_isi',
                'status_pendaftaran' => 'pending',
            ],
            [
                'nama' => 'Ahmad Rizki',
                'email' => 'ahmad@example.com',
                'no_hp' => '081234567892',
                'asal_smp' => 'SMP Negeri 3 Jakarta',
                'status_pembayaran' => 'sudah_bayar',
                'status_formulir' => 'lengkap',
                'status_pendaftaran' => 'diterima',
            ],
        ];

        foreach ($siswaData as $data) {
            CalonSiswa::create([
                'no_pendaftaran' => 'PSB' . date('Y') . Str::random(6),
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'no_hp' => $data['no_hp'],
                'asal_smp' => $data['asal_smp'],
                'id_jurusan' => $jurusan->id,
                'status_pembayaran' => $data['status_pembayaran'],
                'status_formulir' => $data['status_formulir'],
                'status_pendaftaran' => $data['status_pendaftaran'],
                'is_verified' => true,
            ]);
        }

        $this->command->info('3 calon siswa dummy berhasil dibuat!');
    }
}
