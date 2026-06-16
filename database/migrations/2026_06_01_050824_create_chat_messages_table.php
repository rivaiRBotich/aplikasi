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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pesan ke id room chat (jika room dihapus, pesan ikut terhapus)
            $table->foreignId('chat_room_id')->constrained('chat_rooms')->onDelete('cascade');
            // Menghubungkan ke id pengirim (bisa user/pasien atau dokter dari tabel users)
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            // Kolom isi pesan teks
            $table->text('message');
            // Status apakah pesan sudah dibaca oleh lawan bicara
            $table->boolean('is_read')->default(false);
            // Kolom created_at & updated_at untuk penanda waktu chat kirim
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};