<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotMessage extends Model
{
    protected $fillable = ['user_id', 'role', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}