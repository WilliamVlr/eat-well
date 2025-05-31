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
        Schema::create('delivery_statuses', function (Blueprint $table) {
            $table->id('statusId');
            $table->unsignedBigInteger('orderId');
            $table->dateTime('deliveryDate');
            // $table->enum('slot', ['Morning', 'Afternoon', 'Evening']);
            $table->string('slot');
            // $table->enum('status', ['Prepared', 'Delivered', 'Arrived']);
            $table->string('status');
            $table->timestamps();

            $table->foreign('orderId')->references('orderId')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_statuses');
    }
};
