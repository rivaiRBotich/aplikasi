<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatTariff extends Model
{
    protected $table = 'chat_tariffs';
    protected $fillable = ['category', 'price', 'doctor_percentage'];
}
