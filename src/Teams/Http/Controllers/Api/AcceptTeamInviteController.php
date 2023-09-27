<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\JsonController;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;
use MetricsWave\Teams\TeamInvite;

class AcceptTeamInviteController extends JsonController
{
    public function __invoke(Team $team, TeamInvite $invite): JsonResponse
    {
        try {
            $user = User::query()->where('email', $invite->email)->firstOrFail();
        } catch (ModelNotFoundException) {
            return $this->errorResponse("Create your account with email {$invite->email} first.");
        }

        if (! $team->users->contains($user)) {
            $team->users()->attach($user);
        }

        $invite->delete();

        return $this->createdResponse();
    }
}
