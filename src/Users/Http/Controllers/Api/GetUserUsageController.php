<?php

namespace MetricsWave\Users\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;

class GetUserUsageController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response(
            [
                'usage' => $this->user()->triggerNotificationVisits()->period('month')->count(),
            ]
        );
    }
}
