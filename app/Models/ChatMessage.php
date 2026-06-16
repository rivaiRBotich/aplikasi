<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    // Tentukan nama tabel di database
    protected $table = 'chat_messages';

    // Izinkan kolom-kolom ini diisi secara massal
    protected $fillable = [
        'chat_room_id',
        'sender_id',
        'message',
        'is_read',
    ];

    /**
     * Hubungan pesan ke pemilik Ruang Chat
     */
    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }

    /**
     * Hubungan pesan ke Pengirim (bisa Pasien atau Dokter)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}