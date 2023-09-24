<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\PostDashboardRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use MetricsWave\Teams\Team;

class PostDashboardsController extends ApiAuthJsonController
{
    public function __invoke(Team $team, PostDashboardRequest $request): JsonResponse
    {
        $team->dashboards()->create([
            ...$request->validated(),
            ...['uuid' => Str::random(15)],
        ]);

        return $this->noContentResponse();
    }
}
