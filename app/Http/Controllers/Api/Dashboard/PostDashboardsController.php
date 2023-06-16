<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\PostDashboardRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PostDashboardsController extends ApiAuthJsonController
{
    public function __invoke(PostDashboardRequest $request): JsonResponse
    {
        $this->user()->dashboards()->create([
            ...$request->validated(),
            ...['uuid' => Str::random(15)]
        ]);

        return $this->noContentResponse();
    }
}
