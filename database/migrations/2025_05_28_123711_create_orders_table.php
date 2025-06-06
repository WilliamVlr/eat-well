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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orderId');
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('vendorId');
            $table->unsignedBigInteger('addressId');
            $table->decimal('totalPrice', 10, 2)->nullable(false);
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->boolean('isCancelled')->default(false);
            $table->timestamps();

            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table->foreign('vendorId')->references('vendorId')->on('vendors')->onDelete('cascade');
            $table->foreign('addressId')->references('addressId')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
