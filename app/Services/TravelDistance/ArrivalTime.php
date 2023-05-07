<?php

namespace App\Services\TravelDistance;

use Illuminate\Support\Carbon;

class ArrivalTime
{
    public function __construct(public readonly Carbon $date)
    {
    }

    public static function now(): self
    {
        return new self(Carbon::now());
    }

    public function timestamp(): int
    {
        return $this->date->timestamp;
    }
}
