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
        private readonly Carbon $startAt,
        public readonly bool $isAllDay,
    ) {
    }

    public function notificationData(): array
    {
        return [
            'title' => $this->summary,
        ];
    }

    public function startAt(): Carbon
    {
        return $this->startAt->clone();
    }
}
