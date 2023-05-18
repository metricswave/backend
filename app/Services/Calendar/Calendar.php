<?php

namespace App\Services\Calendar;

class Calendar
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $foregroundColor,
        public readonly ?string $backgroundColor,
        public readonly string $timeZone,
    ) {
    }
}
