<?php

namespace App\Services\Prices;

use Spatie\LaravelData\Data;

class LandingPrices extends Data
{
    public function __construct(
        public array $prices,
    ) {
    }
}
