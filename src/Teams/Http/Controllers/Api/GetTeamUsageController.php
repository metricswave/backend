<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;

class GetTeamUsageController extends ApiAuthJsonController
{
    public function __invoke(Team $team): JsonResponse
    {
        abort_unless($this->user()->hasAccessToTeam($team), 403);

        return $this->response(
            [
                'usage' => $team->triggerNotificationVisits()->period('month')->count(),
            ]
        );
    }
}
