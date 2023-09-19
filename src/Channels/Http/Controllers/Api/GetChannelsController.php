<?php

namespace MetricsWave\Channels\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Channels\Channel;

class GetChannelsController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response(
            Channel::all()->toArray(),
        );
    }
}
