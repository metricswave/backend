<?php

namespace App\Transfers;

class Weekday
{
    public function __construct(public readonly int $dayOfWeek)
    {
    }

    public static function fromDayOfWeek(int $dayOfWeek): static
    {
        return new static($dayOfWeek);
    }

    public function toString(): string
    {
        return [
            0 => 'sunday',
            1 => 'monday',
            2 => 'tuesday',
            3 => 'wednesday',
            4 => 'thursday',
            5 => 'friday',
            6 => 'saturday',
        ][$this->dayOfWeek];
    }
}
