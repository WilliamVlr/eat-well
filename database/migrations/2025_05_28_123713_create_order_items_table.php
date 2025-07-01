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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('orderItemId');
            $table->unsignedBigInteger('orderId')->nullable(false);
            $table->unsignedBigInteger('packageId')->nullable(false);
            // $table->enum('packageTimeSlot', ['Morning', 'Afternoon', 'Evening']);
            $table->string('packageTimeSlot');
            $table->decimal('price', 12, 2);
            $table->integer('quantity');
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('orderId')->references('orderId')->on('orders')->onDelete('cascade');
            $table->foreign('packageId')->references('packageId')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
