<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'remaining', 'total_available'];

    protected $casts = [
        'price' => 'integer',
        'remaining' => 'integer',
        'total_available' => 'integer',
    ];

    public function isAvailable(): bool
    {
        return $this->remaining > 0;
    }
}
