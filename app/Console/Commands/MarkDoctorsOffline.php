<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MarkDoctorsOffline extends Command
{
    protected $signature   = 'doctors:mark-offline';
    protected $description = 'Tandai dokter offline jika tidak ada heartbeat';

    public function handle()
    {
        $affected = DB::table('users')
            ->where('role', 'doctor')
            ->where('is_online', 1)
            ->where('last_seen_at', '<', now()->subMinutes(1))
            ->update(['is_online' => 0]);

        $this->info("$affected dokter ditandai offline.");
    }
}