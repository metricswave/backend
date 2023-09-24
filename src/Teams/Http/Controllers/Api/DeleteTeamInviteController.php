<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;
use MetricsWave\Teams\TeamInvite;

class DeleteTeamInviteController extends ApiAuthJsonController
{
    public function __invoke(Team $team, TeamInvite $invite): JsonResponse
    {
        $team->invites()->where('id', $invite->id)->delete();

        return $this->noContentResponse();
    }
}
