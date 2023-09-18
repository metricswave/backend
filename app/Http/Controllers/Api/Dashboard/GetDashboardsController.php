<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use MetricsWave\Teams\Team;

class GetDashboardsController extends ApiAuthJsonController
{
    public function __invoke(Team $team): JsonResponse
    {
        $this->createDefaultIfUserHasNotAny($team);

        return $this->response(
            $team->dashboards()->get()->toArray()
        );
    }

    private function createDefaultIfUserHasNotAny(Team $team): void
    {
        if ($team->dashboards->isEmpty()) {
            $team->dashboards()->create([
                'name' => 'Default',
                'team_id' => $this->user()->ownedTeams()->first()->id,
                'uuid' => Str::random(15),
                'public' => false,
                'items' => [],
            ]);
        }
    }
}
