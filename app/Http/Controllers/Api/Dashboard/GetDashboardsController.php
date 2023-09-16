<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class GetDashboardsController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        $this->createDefaultTeamIfUserHasNotAny();
        $this->createDefaultIfUserHasNotAny();

        return $this->response(
            $this->user()->dashboards()->get()->toArray()
        );
    }

    private function createDefaultTeamIfUserHasNotAny(): void
    {
        if ($this->user()->ownedTeams->isEmpty()) {
            $this->user()->ownedTeams()->create([
                'domain' => 'Default',
            ]);
        }
    }

    private function createDefaultIfUserHasNotAny(): void
    {
        if ($this->user()->dashboards->isEmpty()) {
            $this->user()->dashboards()->create([
                'name' => 'Default',
                'team_id' => $this->user()->ownedTeams()->first()->id,
                'uuid' => Str::random(15),
                'public' => false,
                'items' => [],
            ]);
        }
    }
}
