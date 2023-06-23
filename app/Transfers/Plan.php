<?php

namespace App\Transfers;

use Spatie\LaravelData\Data;

class Plan extends Data
{
    public function __construct(
        readonly public PlanId $id,
        readonly public string $name,
        readonly public int|null $monthlyPrice,
        readonly public bool $yearlyDiscount,
        readonly public int|null $dataRetentionInMonths,
        readonly public int|null $eventsLimit,
        readonly public bool $dedicatedSupport,
    ) {
    }
}
