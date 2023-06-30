<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Services\Plans\PlanGetter;
use Illuminate\Http\JsonResponse;

class GetPlansController extends ApiAuthJsonController
{
    public function __construct(private readonly PlanGetter $planGetter)
    {
        parent::__construct();
    }

    public function __invoke(): JsonResponse
    {
        return $this->response(
            $this->planGetter->all()->toArray()
        );
    }
}
