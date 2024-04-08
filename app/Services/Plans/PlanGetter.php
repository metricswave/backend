<?php

namespace App\Services\Plans;

use App\Transfers\Plan;
use App\Transfers\PlanId;
use Illuminate\Support\Collection;

class PlanGetter
{
    public const BASIC_PRODUCT_ID = 'prod_OB1lbP1pyUy5E0';

    public const STARTER_PRODUCT_ID = 'prod_OB1pdLUu9FIBGh';

    public const BUSINESS_PRODUCT_ID = 'prod_OCTDyX3AR3DRul';

    public function get(PlanId $id): Plan
    {
        return $this->all()->first(fn (Plan $plan) => $plan->id === $id);
    }

    public function all(): Collection
    {
        return collect(value: [
            new Plan(PlanId::FREE, 'Free', 0, false, 6, 20000, false),
            new Plan(
                id: PlanId::BASIC,
                name: 'Basic',
                monthlyPrice: 995,
                yearlyPrice: 11000,
                dataRetentionInMonths: 12,
                eventsLimit: 50000,
                dedicatedSupport: false,
                productStripeId: self::BASIC_PRODUCT_ID,
                monthlyPriceStripeId: 'price_1NOfhbDpKR4Se5u8lPzm7X4F',
                yearlyPriceStripeId: 'price_1NOfhbDpKR4Se5u8QcTpZUTl'
            ),
            new Plan(
                id: PlanId::STARTER,
                name: 'Starter',
                monthlyPrice: 2995,
                yearlyPrice: 29950,
                dataRetentionInMonths: 24,
                eventsLimit: 75000,
                dedicatedSupport: true,
                productStripeId: self::STARTER_PRODUCT_ID,
                monthlyPriceStripeId: 'price_1NOflyDpKR4Se5u8nvIxnEah',
                yearlyPriceStripeId: 'price_1NOflyDpKR4Se5u8Ni02CvDH',
            ),
            new Plan(
                id: PlanId::BUSINESS,
                name: 'Business',
                monthlyPrice: 4995,
                yearlyPrice: 49950,
                dataRetentionInMonths: 24,
                eventsLimit: 1000000,
                dedicatedSupport: true,
                productStripeId: self::BUSINESS_PRODUCT_ID,
                monthlyPriceStripeId: 'price_1NQ4HLDpKR4Se5u8NkfW8mCu',
                yearlyPriceStripeId: 'price_1NQ4HLDpKR4Se5u86q7E6Kqg',
            ),
            new Plan(
                id: PlanId::ENTERPRISE,
                name: 'Enterprise',
                monthlyPrice: null,
                yearlyPrice: null,
                dataRetentionInMonths: null,
                eventsLimit: null,
                dedicatedSupport: true
            ),
        ]);
    }
}
