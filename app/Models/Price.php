<?php

namespace App\Models;

use App\Transfers\PriceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPrice
 */
class Price extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'remaining', 'total_available', 'type'];

    protected $casts = [
        'price' => 'integer',
        'remaining' => 'integer',
        'total_available' => 'integer',
        'type' => PriceType::class,
    ];

    public function isAvailable(): bool
    {
        return $this->remaining > 0;
    }
}
