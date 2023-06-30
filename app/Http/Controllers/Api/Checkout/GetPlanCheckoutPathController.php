<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Controllers\Checkout\HasCheckoutSessions;
use App\Services\Plans\PlanGetter;
use App\Transfers\PlanId;
use Illuminate\Http\JsonResponse;

class GetPlanCheckoutPathController extends ApiAuthJsonController
{
    use HasCheckoutSessions;

    public function __construct(private readonly PlanGetter $planGetter)
    {
        parent::__construct();
    }

    public function __invoke(int $planId, string $period): JsonResponse
    {
        $plan = $this->planGetter->get(
            PlanId::from($planId)
        );

        return $this->response([
            'path' => $this->authCheckoutStripeProduct(
                $this->user(),
                $plan->productStripeId,
                $period === 'monthly' ?
                    $plan->monthlyPriceStripeId :
                    $plan->yearlyPriceStripeId
            )->url,
        ]);
    }
}
