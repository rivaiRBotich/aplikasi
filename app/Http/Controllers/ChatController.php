<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\ChatRoom;
// use App\Models\ChatMessage;
// use App\Events\MessageSent;
// use Illuminate\Support\Facades\Auth;

// class ChatController extends Controller
// {
//     // Tampilkan ruang obrolan chat room
//     public function showSpace($id)
//     {
//         $room = ChatRoom::with(['patient', 'doctor'])->findOrFail($id);
//         $user = Auth::user();

//         // Keamanan tambahan: cegah user asing masuk via ketik URL manual
//         if ($user->id !== $room->user_id && $user->id !== $room->doctor_id && $user->role !== 'admin') {
//             abort(403, 'Anda tidak memiliki akses ke ruang konsultasi ini.');
//         }

//         // Ambil riwayat chat lama dalam room ini
//         $messages = ChatMessage::with('sender')->where('chat_room_id', $room->id)->oldest()->get();

//         return view('chat_space', compact('room', 'messages', 'user'));
//     }

//     // Kirim pesan baru (Dipicu via AJAX dari frontend)
//     public function sendMessage(Request $request, $id)
//     {
//         $request->validate([
//             'message' => 'required|string'
//         ]);

//         // 1. Simpan pesan ke database mbc_clinic
//         $msg = ChatMessage::create([
//             'chat_room_id' => $id,
//             'sender_id' => Auth::id(),
//             'message' => $request->message
//         ]);

//         // 2. Siarkan (Broadcast) pesan secara real-time via WebSocket Reverb
//         broadcast(new MessageSent($msg))->toOthers();

//         // Kembalikan response sukses beserta struktur datanya berbentuk JSON
//         return response()->json([
//             'status' => 'Pesan terkirim!',
//             'message' => $msg->load('sender')
//         ]);
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function showSpace($id)
    {
        $room = ChatRoom::with(['patient', 'doctor'])->findOrFail($id);
        $user = Auth::user();

        // ✅ Ganti patient_id → user_id
        if ($user->id !== $room->user_id && $user->id !== $room->doctor_id && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke ruang konsultasi ini.');
        }

        $messages = ChatMessage::with('sender')
            ->where('chat_room_id', $room->id)
            ->oldest()
            ->get();

        return view('chat_space', compact('room', 'messages', 'user'));
    }
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        $room = ChatRoom::findOrFail($id);
        $user = Auth::user();

        // ✅ Ganti patient_id → user_id
        if ($user->id !== $room->user_id && $user->id !== $room->doctor_id) {
            abort(403);
        }

        // if ($room->status !== 'active') {
        //     return response()->json(['error' => 'Sesi konsultasi ini sudah berakhir.'], 403);
        // }

        // Hanya ditolak kalau room sudah 'closed' (sesi selesai)
        if ($room->status === 'closed') {
            return response()->json(['error' => 'Sesi konsultasi ini sudah berakhir.'], 403);
        }

        $msg = ChatMessage::create([
            'chat_room_id' => $id,
            'sender_id'    => $user->id,
            'message'      => $request->message,
        ]);

        $room->touch();

        broadcast(new MessageSent($msg))->toOthers();

        return response()->json([
            'status'  => 'Pesan terkirim!',
            'message' => $msg->load('sender'),
            'room_status' => $room->status,
        ]);
    }

}