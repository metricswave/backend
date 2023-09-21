<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;
use MetricsWave\Teams\TeamInvite;

class AcceptTeamInviteController extends ApiAuthJsonController
{
    public function __invoke(Team $team, TeamInvite $invite): JsonResponse
    {
        $team->users()->attach(
            User::query()->where('email', $invite->email)->firstOrFail(),
        );

        $invite->delete();

        return $this->createdResponse();
    }
}
