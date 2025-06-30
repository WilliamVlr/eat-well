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
        Schema::create('vendor_reviews', function (Blueprint $table) {
            $table->id('reviewId');
            $table->unsignedBigInteger('vendorId')->nullable(false);
            $table->unsignedBigInteger('userId')->nullable(false);
            $table->unsignedBigInteger('orderId')->nullable(false);
            $table->decimal('rating', 2, 1);
            $table->text('review')->nullable();
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('vendorId')->references('vendorId')->on('vendors')->onDelete('cascade');
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table->foreign('orderId')->references('orderId')->on('orders')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_reviews');
    }
};
