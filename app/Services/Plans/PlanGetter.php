<?php

namespace App\Services\Plans;

use App\Transfers\Plan;
use App\Transfers\PlanId;
use MetricsWave\Plan\Plans;

class PlanGetter
{
    private const YEARLY_DISCOUNT = 0.8; // 20%

    public function get(PlanId $id): Plan
    {
        return $this->all()->first(fn(Plan $plan) => $plan->id === $id);
    }

    public function all(): Plans
    {
        return new Plans([
            new Plan(PlanId::FREE, 'Free', 0, false, 6, 10000, false),
            new Plan(
                id: PlanId::BASIC,
                name: 'Basic',
                monthlyPrice: 895,
                yearlyPrice: 895 * 12 * self::YEARLY_DISCOUNT,
                dataRetentionInMonths: 12,
                eventsLimit: 25000,
                dedicatedSupport: false,
                productStripeId: config('services.stripe.basic.id'),
                monthlyPriceStripeId: config('services.stripe.basic.monthly_price', 'price_1NOfhbDpKR4Se5u8lPzm7X4F'),
                yearlyPriceStripeId: config('services.stripe.basic.yearly_price', 'price_1NOfhbDpKR4Se5u8QcTpZUTl'),
                eurMonthlyPriceStripeId: config('services.stripe.basic.eur_monthly_price', ''),
                eurYearlyPriceStripeId: config('services.stripe.basic.eur_yearly_price', '')
            ),
            new Plan(
                id: PlanId::STARTER,
                name: 'Starter',
                monthlyPrice: 1995,
                yearlyPrice: 1995 * 12 * self::YEARLY_DISCOUNT,
                dataRetentionInMonths: 24,
                eventsLimit: 100000,
                dedicatedSupport: true,
                productStripeId: config('services.stripe.starter.id'),
                monthlyPriceStripeId: config('services.stripe.starter.monthly_price', 'price_1NOflyDpKR4Se5u8nvIxnEah'),
                yearlyPriceStripeId: config('services.stripe.starter.yearly_price', 'price_1NOflyDpKR4Se5u8Ni02CvDH'),
                eurMonthlyPriceStripeId: config('services.stripe.starter.eur_monthly_price', ''),
                eurYearlyPriceStripeId: config('services.stripe.starter.eur_yearly_price', '')
            ),
            new Plan(
                id: PlanId::BUSINESS,
                name: 'Business',
                monthlyPrice: 3995,
                yearlyPrice: 3995 * 12 * self::YEARLY_DISCOUNT,
                dataRetentionInMonths: 24,
                eventsLimit: 300000,
                dedicatedSupport: true,
                productStripeId: config('services.stripe.business.id'),
                monthlyPriceStripeId: config('services.stripe.business.monthly_price', 'price_1NQ4HLDpKR4Se5u8NkfW8mCu'),
                yearlyPriceStripeId: config('services.stripe.business.yearly_price', 'price_1NQ4HLDpKR4Se5u86q7E6Kqg'),
                eurMonthlyPriceStripeId: config('services.stripe.business.eur_monthly_price', ''),
                eurYearlyPriceStripeId: config('services.stripe.business.eur_yearly_price', '')
            ),
            new Plan(
                id: PlanId::CORPORATE,
                name: 'Corporate',
                monthlyPrice: 5995,
                yearlyPrice: 5995 * 12 * self::YEARLY_DISCOUNT,
                dataRetentionInMonths: 24,
                eventsLimit: 1000000,
                dedicatedSupport: true,
                productStripeId: config('services.stripe.business.id'),
                monthlyPriceStripeId: config('services.stripe.corporate.monthly_price', 'price_1NQ4HLDpKR4Se5u8NkfW8mCu'),
                yearlyPriceStripeId: config('services.stripe.corporate.yearly_price', 'price_1NQ4HLDpKR4Se5u86q7E6Kqg'),
                eurMonthlyPriceStripeId: config('services.stripe.corporate.eur_monthly_price', ''),
                eurYearlyPriceStripeId: config('services.stripe.corporate.eur_yearly_price', '')
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
