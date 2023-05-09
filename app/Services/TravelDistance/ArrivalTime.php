<?php

namespace App\Services\TravelDistance;

use Illuminate\Support\Carbon;

class ArrivalTime
{
    public function __construct(public readonly Carbon $date)
    {
    }

    public static function fromTimeFormatted(string $time): self
    {
        return new self(
            Carbon::now()->setTime(
                (int) substr($time, 0, 2),
                (int) substr($time, 3, 2)
            )
        );
    }

    public static function now(): self
    {
        return new self(Carbon::now());
    }

    public function timestamp(): int
    {
        return $this->date->timestamp;
    }

    public function timeFormatted(): string
    {
        return $this->date->toTimeString('minute');
    }
}
