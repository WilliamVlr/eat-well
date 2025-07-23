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
            $table->unsignedBigInteger('userId')->nullable(); // sesuaikan dengan tabel 'users'
            $table->string('name')->nullable();
            $table->string('role')->nullable();
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->string('method')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('accessed_at')->nullable();
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
