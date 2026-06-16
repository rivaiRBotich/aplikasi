<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorCommission extends Model
{
    protected $fillable = [
        'doctor_id', 'month', 'year',
        'total_commission', 'total_chats',
        'status', 'paid_at', 'paid_by',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}