<?php

namespace App\Services\Plans;

use App\Transfers\Plan;
use App\Transfers\PlanId;
use Illuminate\Support\Collection;

class PlanGetter
{
    public function get(PlanId $id): Plan
    {
        return $this->all()->first(fn(Plan $plan) => $plan->id === $id);
    }

    public function all(): Collection
    {
        return collect(value: [
            new Plan(PlanId::FREE, 'Free', 0, false, 6, 1000, false),
            new Plan(
                id: PlanId::BASIC,
                name: 'Basic',
                monthlyPrice: 995,
                yearlyPrice: 11000,
                dataRetentionInMonths: 12,
                eventsLimit: 25000,
                dedicatedSupport: false,
                productStripeId: 'prod_OB1lbP1pyUy5E0',
                monthlyPriceStripeId: 'price_1NOfhbDpKR4Se5u8lPzm7X4F',
                yearlyPriceStripeId: 'price_1NOfhbDpKR4Se5u8QcTpZUTl'
            ),
            new Plan(
                id: PlanId::BUSINESS,
                name: 'Business',
                monthlyPrice: 2995,
                yearlyPrice: 29950,
                dataRetentionInMonths: 24,
                eventsLimit: 75000,
                dedicatedSupport: true,
                productStripeId: 'prod_OB1pdLUu9FIBGh',
                monthlyPriceStripeId: 'price_1NOflyDpKR4Se5u8nvIxnEah',
                yearlyPriceStripeId: 'price_1NOflyDpKR4Se5u8Ni02CvDH',
            ),
            new Plan(
                id: PlanId::ENTERPRISE,
                name: 'Enterprise',
                monthlyPrice: null,
                yearlyPrice: false,
                dataRetentionInMonths: null,
                eventsLimit: null,
                dedicatedSupport: true
            ),
        ]);
    }
}
