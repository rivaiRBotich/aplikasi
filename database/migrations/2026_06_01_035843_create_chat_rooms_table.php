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
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID Pasien
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('set null'); // ID Dokter
            $table->string('category'); // Kategori: umum, kecantikan, gigi
            $table->integer('price_at_time'); // Menyimpan harga tarif saat chat dibuat (untuk perhitungan komisi)
            $table->enum('status', ['pending', 'active', 'closed'])->default('pending'); // Status chat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_rooms');
    }
};