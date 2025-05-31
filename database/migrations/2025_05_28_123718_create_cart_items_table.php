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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->unsignedBigInteger('cartId');
            $table->unsignedBigInteger('packageId');
            $table->integer('breakfastQty')->default(0);
            $table->integer('lunchQty')->default(0);
            $table->integer('dinnerQty')->default(0);
            $table->timestamps();

            $table->primary(['cartId', 'packageId']);

            $table->foreign('packageId')->references('packageId')->on('packages')->onDelete('cascade');
            $table->foreign('cartId')->references('cartId')->on('cart')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
