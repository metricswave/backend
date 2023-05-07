<?php

namespace App\Services\TravelDistance;

class Duration
{
    public function __construct(
        public readonly string $duration,
        public readonly int $seconds
    ) {
    }
}
