<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Controllers\Checkout\HasCheckoutSessions;
use App\Models\Price;
use Illuminate\Http\JsonResponse;

class GetPriceCheckoutPathController extends ApiAuthJsonController
{
    use HasCheckoutSessions;

    public function __invoke(Price $price): JsonResponse
    {
        return $this->response([
            'path' => $this->authCheckout($price)->asStripeCheckoutSession()->url,
        ]);
    }
}
