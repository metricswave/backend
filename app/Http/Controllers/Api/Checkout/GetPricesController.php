<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Services\Prices\GetAppPricesService;
use Illuminate\Http\JsonResponse;

class GetPricesController extends ApiAuthJsonController
{
    public function __construct(private readonly GetAppPricesService $appPricesService)
    {
        parent::__construct();
    }

    public function __invoke(): JsonResponse
    {
        return $this->response(
            ($this->appPricesService)()->toArray()
        );
    }
}
