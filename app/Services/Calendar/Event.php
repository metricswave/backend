<?php

namespace App\Services\Calendar;

use Carbon\Carbon;

class Event
{
    public function __construct(
        public readonly string $id,
        public readonly string $summary,
        public readonly ?string $location,
        public readonly Carbon $startAt,
    ) {
    }
}
