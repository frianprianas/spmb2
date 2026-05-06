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
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran', 20)->unique();
            $table->string('nama', 100);
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('asal_smp', 100);
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->string('email', 100)->unique();
            $table->string('no_hp', 20);
            $table->enum('status_pembayaran', ['belum_bayar', 'sudah_bayar', 'verifikasi'])->default('belum_bayar');
            $table->enum('status_formulir', ['belum_isi', 'sudah_isi', 'lengkap'])->default('belum_isi');
            $table->enum('status_pendaftaran', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};
