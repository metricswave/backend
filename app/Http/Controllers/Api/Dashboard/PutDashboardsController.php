<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\PutDashboardRequest;
use App\Models\Dashboard;
use Illuminate\Http\JsonResponse;

class PutDashboardsController extends ApiAuthJsonController
{
    public function __invoke(Dashboard $dashboard, PutDashboardRequest $request): JsonResponse
    {
        $dashboard->update($request->validated());

        return $this->noContentResponse();
    }
}
