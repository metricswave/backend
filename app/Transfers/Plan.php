<?php

namespace App\Transfers;

use Spatie\LaravelData\Data;

class Plan extends Data
{
    public function __construct(
        readonly public PlanId $id,
        readonly public string $name,
        readonly public ?int $monthlyPrice,
        readonly public ?int $yearlyPrice,
        readonly public ?int $dataRetentionInMonths,
        readonly public ?int $eventsLimit,
        readonly public bool $dedicatedSupport,
        readonly public ?string $productStripeId = null,
        readonly public ?string $monthlyPriceStripeId = null,
        readonly public ?string $yearlyPriceStripeId = null,
    ) {
    }
}
