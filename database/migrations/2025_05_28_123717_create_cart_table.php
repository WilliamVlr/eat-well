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
        Schema::create('cart', function (Blueprint $table) {
            $table->id('cartId');
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('vendorId');
            $table->decimal('totalPrice', 10, 2);
            // $table->dateTime('createdAt')->useCurrent()->nullable();
            // $table->dateTime('updatedAt')->useCurrent()->nullable();
            $table->timestamps();

            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table->foreign('vendorId')->references('vendorId')->on('vendors')->onDelete('cascade');

            $table->unique(['userId', 'vendorId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
