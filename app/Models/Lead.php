<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'email', 'paid_price', 'paid_at', 'form_filled'];

    protected $casts = [
        'paid_at' => 'datetime',
        'form_filled' => 'boolean',
    ];
}
