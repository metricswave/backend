<?php

namespace App\Transfers;

use Livewire\Wireable;
use Spatie\LaravelData\Data;

class Plan extends Data implements Wireable
{
    public function __construct(
        readonly public PlanId $id,
        readonly public string $name,
        readonly public ?int $monthlyPrice,
        readonly public ?int $yearlyPrice = null,
        readonly public ?int $dataRetentionInMonths,
        readonly public ?int $eventsLimit,
        readonly public bool $dedicatedSupport,
        readonly public ?string $productStripeId = null,
        readonly public ?string $monthlyPriceStripeId = null,
        readonly public ?string $yearlyPriceStripeId = null,
        readonly public ?string $eurMonthlyPriceStripeId = null,
        readonly public ?string $eurYearlyPriceStripeId = null,
    ) {
    }

    public static function fromLivewire($value): static
    {
        return new static(
            id: PlanId::from($value['id']),
            name: $value['name'],
            monthlyPrice: $value['monthlyPrice'],
            yearlyPrice: $value['yearlyPrice'],
            dataRetentionInMonths: $value['dataRetentionInMonths'],
            eventsLimit: $value['eventsLimit'],
            dedicatedSupport: $value['dedicatedSupport'],
            productStripeId: $value['productStripeId'],
            monthlyPriceStripeId: $value['monthlyPriceStripeId'],
            yearlyPriceStripeId: $value['yearlyPriceStripeId'],
            eurMonthlyPriceStripeId: $value['eurMonthlyPriceStripeId'],
            eurYearlyPriceStripeId: $value['eurYearlyPriceStripeId'],
        );
    }

    public function toLivewire(): array
    {
        return $this->toArray();
    }
}
