<?php

namespace App\Services\Calendar;

use App\Transfers\ServiceId;

class CalendarTransfer
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ServiceId $serviceId,
        public readonly ?string $description,
        public readonly ?string $foregroundColor,
        public readonly ?string $backgroundColor,
        public readonly string $timeZone,
    ) {
    }
}
