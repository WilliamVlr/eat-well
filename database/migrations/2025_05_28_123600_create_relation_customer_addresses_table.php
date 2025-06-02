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
        Schema::create('relation_customer_addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('customerId');
            $table->unsignedBigInteger('addressId');
            $table->string('recepient_name');
            $table->string('recepient_phone');
            $table->boolean('is_default');
            $table->string('notes');
            $table->timestamps();

            $table->primary(['customerId', 'addressId']);

            $table->foreign('customerId')->references('userId')->on('users')->onDelete('cascade');
            $table->foreign('addressId')->references('addressId')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relation_customer_addresses');
    }
};
