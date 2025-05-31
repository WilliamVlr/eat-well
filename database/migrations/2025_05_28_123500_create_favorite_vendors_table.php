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
        Schema::create('favorite_vendors', function (Blueprint $table) {
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('vendorId');
            $table->timestamps();

            $table->primary(['userId', 'vendorId']);

            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table->foreign('vendorId')->references('vendorId')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_vendors');
    }
};
