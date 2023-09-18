<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;

class GetTeamsController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response([
            'data' => $this->user()->teams,
        ]);
    }
}
