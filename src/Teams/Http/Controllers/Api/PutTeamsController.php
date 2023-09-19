<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Http\Controllers\Requests\UpdateTeamRequest;
use MetricsWave\Teams\Team;

class PutTeamsController extends ApiAuthJsonController
{
    public function __invoke(Team $team, UpdateTeamRequest $request): JsonResponse
    {
        $team->update($request->validated());

        return $this->noContentResponse();
    }
}
