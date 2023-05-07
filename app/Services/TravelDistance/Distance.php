<?php

namespace App\Services\TravelDistance;

class Distance
{
    public function __construct(
        public readonly string $distance,
        public readonly int $meters
    ) {
    }
}
