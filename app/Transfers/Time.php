<?php

namespace App\Transfers;

class Time
{
    public function __construct(public readonly string $time)
    {
    }

    public static function fromString(string $time): static
    {
        return new static($time);
    }

    public function toString(): string
    {
        return $this->time;
    }
}
