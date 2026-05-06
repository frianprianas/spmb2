<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuangan;
use Illuminate\Support\Facades\Hash;

class KeuanganSeeder extends Seeder
{
    public function run()
    {
        Keuangan::create([
            'username' => 'keuangan',
            'nama' => 'Staff Keuangan',
            'email' => 'keuangan@smkbaktinusantara666.sch.id',
            'password' => Hash::make('password'),
        ]);
    }
}
