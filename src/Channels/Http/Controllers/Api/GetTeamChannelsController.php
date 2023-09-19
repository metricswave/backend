<?php

namespace MetricsWave\Channels\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;

class GetTeamChannelsController extends ApiAuthJsonController
{
    public function __invoke(Team $team): JsonResponse
    {
        return $this->response(
            $team->channels->toArray()
        );
    }
}
