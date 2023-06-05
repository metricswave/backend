<?php

namespace App\Services\Prices;

use App\Models\Price;
use Spatie\LaravelData\Data;

class LandingPrices extends Data
{
    public function __construct(
        public Price $monthly,
        public Price $lifetime,
    ) {
    }
}
