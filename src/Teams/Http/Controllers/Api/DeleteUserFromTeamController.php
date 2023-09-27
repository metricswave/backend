<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;

class DeleteUserFromTeamController extends ApiAuthJsonController
{
    public function __invoke(Team $team, User $user): JsonResponse
    {
        abort_unless(
            $this->user()->hasAccessToTeam($team),
            403
        );

        $team->users()->detach($user);

        return $this->createdResponse();
    }
}
