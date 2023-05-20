<?php

namespace App\Services\Calendar;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class Event extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $summary,
        public readonly ?string $location,
        public readonly Carbon $startAt,
        public readonly bool $isAllDay,
        public readonly bool $isConfirmed,
    ) {
    }

    public function notificationData(): array
    {
        return [
            'title' => $this->summary,
            'date' => $this->startAt()->format('d/m.Y'),
            'time' => $this->startAt()->format('H:i'),
        ];
    }

    public function startAt(): Carbon
    {
        return $this->startAt->clone();
    }
}
