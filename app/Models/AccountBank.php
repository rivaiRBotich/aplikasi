<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountBank extends Model
{
    use HasFactory;
    protected $table = 'acount_bank';

    protected $fillable = [
        'nama_bank',
        'account',
        'nama_penerima',
    ];
}
