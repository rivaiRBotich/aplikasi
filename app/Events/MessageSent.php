<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // <-- PASTIKAN IMPLEMENTS INI ADA

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatMessage $message)
    {
        // == KUNCI UTAMA DI SINI ==
        // Pastikan relasi 'sender' (si pengirim) ikut dimuat sebelum paket dikirim via WebSocket
        $this->message = $message->load('sender');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // Pastikan nama channel-nya sesuai dengan rute channels.php Anda
        return [
            new \Illuminate\Broadcasting\PrivateChannel('chat.room.' . $this->message->chat_room_id),
        ];
    }

    /**
     * Nama alias event di frontend (agar terbaca sebagai .message.sent)
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}