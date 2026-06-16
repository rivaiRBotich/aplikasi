<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\ChatRoom;

// Broadcast::channel('chat.room.{roomId}', function ($user, $roomId) {
//     // Kita cek apakah user sudah login. Jika belum, tendang.
//     if (!$user) {
//         return false;
//     }

//     // Ambil data room untuk memastikan hanya orang yang terlibat yang bisa 'mendengar'
//     $room = ChatRoom::find($roomId);
//     if (!$room) {
//         return false;
//     }

//     // Kembalikan true jika yang mengakses adalah Pasien, Dokter, atau Admin
//     return (int) $user->id === (int) $room->user_id || 
//            (int) $user->id === (int) $room->doctor_id || 
//            $user->role === 'admin';
// });

// Channel presence untuk dashboard dokter
Broadcast::channel('doctors.online', function ($user) {
    if ($user->role === 'doctor') {
        return [
            'id'   => $user->id,
            'name' => $user->name,
        ];
    }
    return false;
});

// Channel yang sudah ada
Broadcast::channel('chat.room.{roomId}', function ($user, $roomId) {
    $room = ChatRoom::find($roomId);
    if (!$room) return false;

    return (int) $user->id === (int) $room->user_id || 
           (int) $user->id === (int) $room->doctor_id || 
           $user->role === 'admin';
});