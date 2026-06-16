<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $table = 'chat_rooms';

    protected $fillable = [
        'user_id',
        'doctor_id',
        'category',
        'price_at_time',
        'status',
    ];

    // === TAMBAHKAN FUNGSI RELASI INI ===
    /**
     * Hubungan ChatRoom ke data Pasien (User)
     */
    public function patient()
    {
        // Hubungkan kolom user_id di tabel chat_rooms ke kolom id di tabel users
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hubungan ChatRoom ke data Dokter (User) - Jika nanti dibutuhkan di halaman chat
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}