<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TopupCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    public function __construct(
        public int $topupId,
        public string $userName,
        public int $amount,
        public string $proofImage,
        public string $createdAt,
    ) {
    }
 
    public function broadcastOn(): array
    {
        // Channel khusus admin — publik saja (auth admin dicek di route/middleware halaman, bukan di channel)
        return [new Channel('admin.topups')];
    }
 
    public function broadcastAs(): string
    {
        return 'topup.created';
    }
 
    public function broadcastWith(): array
    {
        return [
            'id'          => $this->topupId,
            'user_name'   => $this->userName,
            'amount'      => $this->amount,
            'proof_image' => $this->proofImage,
            'status'      => 'pending',
            'created_at'  => $this->createdAt,
        ];
    }
}