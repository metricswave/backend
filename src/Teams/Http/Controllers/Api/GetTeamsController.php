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
        $ownedTeams = $this->user()->ownedTeams()->with(['owner', 'users'])->get();
        $teams = $this->user()->teams()->with(['owner', 'users'])->get();

        return $this->response([
            ...$this->mapTeamsToArray($ownedTeams),
            ...$this->mapTeamsToArray($teams),
        ]);
    }

    public function mapTeamsToArray(Collection $teams): array
    {
        return $teams
            ->map(fn (Team $t) => [
                ...$t->attributesToArray(),
                'owner' => $t->owner()->first()->makeHidden('all_teams')->toArray(),
                'users' => $t->users()->get()->makeHidden('all_teams')->toArray(),
                'limits' => [
                    'soft' => $t->softLimit(),
                    'hard' => $t->hardLimit(),
                ],
            ])
            ->toArray();
    }
}
