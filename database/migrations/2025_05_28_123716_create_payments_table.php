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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('paymentId');
            $table->unsignedBigInteger('methodId');
            $table->unsignedBigInteger('orderId');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('methodId')->references('methodId')->on('payment_methods')->onDelete('cascade');
            $table->foreign('orderId')->references('orderId')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
