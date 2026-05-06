<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDokumenToCalonSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->string('file_kk')->nullable()->after('is_verified');
            $table->string('status_upload_kk')->default('belum_upload')->after('file_kk');
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
            $table->dropColumn(['file_kk', 'status_upload_kk']);
        });
    }
}
