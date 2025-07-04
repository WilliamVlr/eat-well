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
            $table->string('name')->nullable()->change();
            $table->string('logo')->nullable()->change();
            $table->string('phone_number', 20)->nullable()->change();
            $table->decimal('rating', 2, 1)->nullable()->change();
            $table->string('provinsi')->nullable()->change();
            $table->string('kota')->nullable()->change();
            $table->string('kabupaten')->nullable()->change();
            $table->string('kecamatan')->nullable()->change();
            $table->string('kelurahan')->nullable()->change();
            $table->string('kode_pos')->nullable()->change();
            $table->string('jalan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {

            $table->string('name')->nullable(false)->change();
            $table->string('logo')->nullable(false)->change();
            $table->string('phone_number', 20)->nullable(false)->change();
            $table->decimal('rating', 2, 1)->nullable(false)->change();
            $table->string('provinsi')->nullable(false)->change();
            $table->string('kota')->nullable(false)->change();
            $table->string('kabupaten')->nullable(false)->change();
            $table->string('kecamatan')->nullable(false)->change();
            $table->string('kelurahan')->nullable(false)->change();
            $table->string('kode_pos')->nullable(false)->change();
            $table->string('jalan')->nullable(false)->change();
        });
    }
};
