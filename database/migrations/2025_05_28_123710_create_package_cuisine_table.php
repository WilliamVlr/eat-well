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
        Schema::create('package_cuisine', function (Blueprint $table) {
            $table->unsignedBigInteger('packageId');
            $table->unsignedBigInteger('cuisineId');
            $table->timestamps();

            $table->primary(['packageId', 'cuisineId']);

            $table->softDeletes();
            $table->foreign('packageId')->references('packageId')->on('packages')->onDelete('cascade');
            $table->foreign('cuisineId')->references('cuisineId')->on('cuisine_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_cuisine');
    }
};
