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
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId'); // sesuaikan dengan tabel 'users'
            $table->string('name');
            $table->string('role');
            $table->string('url');
            $table->string('description');
            $table->string('method');
            $table->ipAddress('ip_address');
            $table->timestamp('accessed_at');
            $table->timestamps();

            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
