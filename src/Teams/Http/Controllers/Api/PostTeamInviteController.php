<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use MetricsWave\Teams\Http\Controllers\Requests\CreateInviteTeamRequest;
use MetricsWave\Teams\Team;

class PostTeamInviteController extends ApiAuthJsonController
{
    public function __invoke(Team $team, CreateInviteTeamRequest $request): JsonResponse
    {
        abort_unless(
            $this->user()->hasAccessToTeam($team),
            403
        );

        $team->invites()->create([
            'email' => $request->get('email'),
            'token' => Str::random(20),
        ]);

        return $this->createdResponse();
    }
}
