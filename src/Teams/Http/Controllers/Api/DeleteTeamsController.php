<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;
use Symfony\Component\HttpFoundation\Response;

class DeleteTeamsController extends ApiAuthJsonController
{
    public function __invoke(Team $team): JsonResponse
    {
        if ($this->user()->isOwnerOfTeam($team) === false) {
            return $this->errorResponse('You cannot delete a team you do not own.', Response::HTTP_FORBIDDEN);
        }

        if ($this->user()->ownedTeams()->count() === 1) {
            return $this->errorResponse('You cannot delete your last team.', Response::HTTP_BAD_REQUEST);
        }

        $team->delete();

        return $this->noContentResponse();
    }
}
