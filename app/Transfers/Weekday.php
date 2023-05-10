<?php

namespace App\Transfers;

class Weekday
{
    public function __construct(public readonly int $dayOfWeek)
    {
    }

    public static function fromString(string $weekDay): static
    {
        return new static([
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
        ][$weekDay]);
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
