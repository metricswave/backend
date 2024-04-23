<?php

namespace App\Services\Plans;

use App\Transfers\Plan;
use App\Transfers\PlanId;
use MetricsWave\Plan\Plans;

class PlanGetter
{
    public const BASIC_PRODUCT_ID = 'prod_OB1lbP1pyUy5E0';

    public const STARTER_PRODUCT_ID = 'prod_OB1pdLUu9FIBGh';

    public const BUSINESS_PRODUCT_ID = 'prod_OCTDyX3AR3DRul';

    public function get(PlanId $id): Plan
    {
        return $this->all()->first(fn(Plan $plan) => $plan->id === $id);
    }

    public function all(): Plans
    {
        return new Plans([
            new Plan(PlanId::FREE, 'Free', 0, false, 6, 20000, false),
            new Plan(
                id: PlanId::BASIC,
                name: 'Basic',
                monthlyPrice: 995,
                yearlyPrice: 11000,
                dataRetentionInMonths: 12,
                eventsLimit: 50000,
                dedicatedSupport: false,
                productStripeId: config('services.stripe.basic.id', self::BASIC_PRODUCT_ID),
                monthlyPriceStripeId: config('services.stripe.basic.monthly_price', 'price_1NOfhbDpKR4Se5u8lPzm7X4F'),
                yearlyPriceStripeId: config('services.stripe.basic.yearly_price', 'price_1NOfhbDpKR4Se5u8QcTpZUTl'),
                eurMonthlyPriceStripeId: config('services.stripe.basic.eur_monthly_price', ''),
                eurYearlyPriceStripeId: config('services.stripe.basic.eur_yearly_price', '')
            ),
            new Plan(
                id: PlanId::STARTER,
                name: 'Starter',
                monthlyPrice: 2995,
                yearlyPrice: 29950,
                dataRetentionInMonths: 24,
                eventsLimit: 75000,
                dedicatedSupport: true,
                productStripeId: config('services.stripe.starter.id', self::STARTER_PRODUCT_ID),
                monthlyPriceStripeId: config('services.stripe.starter.monthly_price', 'price_1NOflyDpKR4Se5u8nvIxnEah'),
                yearlyPriceStripeId: config('services.stripe.starter.yearly_price', 'price_1NOflyDpKR4Se5u8Ni02CvDH'),
                eurMonthlyPriceStripeId: config('services.stripe.starter.eur_monthly_price', ''),
                eurYearlyPriceStripeId: config('services.stripe.starter.eur_yearly_price', '')
            ),
            new Plan(
                id: PlanId::BUSINESS,
                name: 'Business',
                monthlyPrice: 4995,
                yearlyPrice: 49950,
                dataRetentionInMonths: 24,
                eventsLimit: 1000000,
                dedicatedSupport: true,
                productStripeId: config('services.stripe.business.id', self::BUSINESS_PRODUCT_ID),
                monthlyPriceStripeId: config('services.stripe.business.monthly_price', 'price_1NQ4HLDpKR4Se5u8NkfW8mCu'),
                yearlyPriceStripeId: config('services.stripe.business.yearly_price', 'price_1NQ4HLDpKR4Se5u86q7E6Kqg'),
                eurMonthlyPriceStripeId: config('services.stripe.business.eur_monthly_price', ''),
                eurYearlyPriceStripeId: config('services.stripe.business.eur_yearly_price', '')
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

    public function paidPlans(): Plans
    {
        return $this->all()
            ->filter(fn(Plan $plan) => $plan->monthlyPrice > 0);
    }
}
