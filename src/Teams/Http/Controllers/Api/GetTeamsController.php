<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;

class GetTeamsController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        $teams = $this->user()->teams()->with(['owner', 'users'])->get();
        $ownedTeams = $this->user()->ownedTeams()->with(['owner', 'users'])->get();

        return $this->response([
            ...$this->toArray($ownedTeams),
            ...$this->toArray($teams),
        ]);
    }

    public function toArray(Collection $teams): array
    {
        return $teams
            ->map(fn (Team $t) => [
                ...$t->attributesToArray(),
                'owner' => $t->owner()->first()->makeHidden('all_teams')->toArray(),
                'users' => $t->users()->get()->makeHidden('all_teams')->toArray(),
            ])
            ->toArray();
    }
}
