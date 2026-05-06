<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationToCalonSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->string('nisn', 10)->nullable()->after('no_pendaftaran');
            $table->string('verification_token', 6)->nullable()->after('password');
            $table->timestamp('verification_token_expires_at')->nullable()->after('verification_token');
            $table->boolean('is_verified')->default(false)->after('verification_token_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'verification_token', 'verification_token_expires_at', 'is_verified']);
        });
    }
}
