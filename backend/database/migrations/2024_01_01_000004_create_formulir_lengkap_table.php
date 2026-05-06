<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formulir_lengkap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->constrained('calon_siswa')->onDelete('cascade');
            
            // Data Pribadi
            $table->string('nik', 16);
            $table->string('nisn', 10)->nullable();
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->string('kewarganegaraan', 20)->default('Indonesia');
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('no_hp_siswa', 20);
            $table->string('email_siswa', 100);
            
            // Alamat Lengkap
            $table->text('alamat_lengkap');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('kelurahan', 50);
            $table->string('kecamatan', 50);
            $table->string('kota', 50);
            $table->string('provinsi', 50);
            $table->string('kode_pos', 10);
            
            // Data Orang Tua/Wali - Ayah
            $table->string('nama_ayah', 100);
            $table->string('nik_ayah', 16)->nullable();
            $table->string('pekerjaan_ayah', 50);
            $table->string('pendidikan_ayah', 30);
            $table->decimal('penghasilan_ayah', 15, 2)->nullable();
            $table->string('no_hp_ayah', 20);
            
            // Data Orang Tua/Wali - Ibu
            $table->string('nama_ibu', 100);
            $table->string('nik_ibu', 16)->nullable();
            $table->string('pekerjaan_ibu', 50);
            $table->string('pendidikan_ibu', 30);
            $table->decimal('penghasilan_ibu', 15, 2)->nullable();
            $table->string('no_hp_ibu', 20);
            
            // Data Wali (jika ada)
            $table->string('nama_wali', 100)->nullable();
            $table->string('hubungan_wali', 30)->nullable();
            $table->string('pekerjaan_wali', 50)->nullable();
            $table->string('no_hp_wali', 20)->nullable();
            $table->text('alamat_wali')->nullable();
            
            // Data SMP/MTs
            $table->string('npsn_smp', 20)->nullable();
            $table->text('alamat_smp')->nullable();
            $table->integer('tahun_lulus');
            $table->decimal('nilai_un', 5, 2)->nullable();
            
            // Dokumen
            $table->string('foto')->nullable();
            $table->string('scan_kk')->nullable();
            $table->string('scan_akta')->nullable();
            $table->string('scan_ijazah')->nullable();
            
            // Prestasi/Informasi Tambahan
            $table->text('prestasi')->nullable();
            $table->text('info_tambahan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_lengkap');
    }
};
