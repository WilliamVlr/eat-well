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
        Schema::create('vendor_previews', function (Blueprint $table) {
            $table->id('vendorPreviewId');
            $table->unsignedBigInteger('vendorId');
            $table->string('previewPicturePath');
            $table->timestamps();

            $table->foreign('vendorId')->references('vendorId')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_previews');
    }
};
