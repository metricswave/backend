<?php

namespace App\Transfers;

use Spatie\LaravelData\Data;

class Plan extends Data
{
    public function __construct(
        readonly public PlanId $id,
        readonly int $eventsLimit,
    ) {
    }
}
