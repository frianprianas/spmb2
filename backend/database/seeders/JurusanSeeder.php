<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = [
            [
                'kode_jurusan' => 'RPL',
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'deskripsi' => 'Program keahlian yang mempelajari dan mendalami cara-cara pengembangan perangkat lunak termasuk pembuatan, pemeliharaan, manajemen organisasi pengembangan perangkat lunak dan manajemen kualitas.',
                'kuota' => 36,
                'is_active' => true
            ],
            [
                'kode_jurusan' => 'DKV',
                'nama_jurusan' => 'Desain Komunikasi Visual',
                'deskripsi' => 'Program keahlian yang mempelajari konsep komunikasi dan ungkapan kreatif, teknik dan media dengan memanfaatkan elemen-elemen visual ataupun rupa untuk menyampaikan pesan.',
                'kuota' => 36,
                'is_active' => true
            ],
            [
                'kode_jurusan' => 'ANM',
                'nama_jurusan' => 'Animasi',
                'deskripsi' => 'Program keahlian yang mempelajari teknik pembuatan animasi 2D dan 3D, motion graphics, dan multimedia interaktif.',
                'kuota' => 36,
                'is_active' => true
            ],
            [
                'kode_jurusan' => 'AKT',
                'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga',
                'deskripsi' => 'Program keahlian yang mempelajari pencatatan, penggolongan, dan pelaporan transaksi keuangan suatu organisasi atau lembaga.',
                'kuota' => 36,
                'is_active' => true
            ],
            [
                'kode_jurusan' => 'PM',
                'nama_jurusan' => 'Pemasaran',
                'deskripsi' => 'Program keahlian yang mempelajari strategi pemasaran, manajemen penjualan, digital marketing, dan komunikasi bisnis.',
                'kuota' => 36,
                'is_active' => true
            ]
        ];

        foreach ($jurusan as $item) {
            DB::table('jurusan')->insert(array_merge($item, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
