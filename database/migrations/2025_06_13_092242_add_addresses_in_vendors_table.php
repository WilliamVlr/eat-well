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
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kode_pos');
            $table->string('jalan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('provinsi');
            $table->dropColumn('kota');
            $table->dropColumn('kabupaten');
            $table->dropColumn('kecamatan');
            $table->dropColumn('kelurahan');
            $table->dropColumn('kode_pos');
            $table->dropColumn('jalan');
        });
    }
};
