<?php

namespace MetricsWave\Users\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;

class GetUserController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response(
            $this->user()->toArray()
        );
    }
}
