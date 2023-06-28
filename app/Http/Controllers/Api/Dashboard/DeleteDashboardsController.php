<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\DeleteDashboardRequest;
use App\Models\Dashboard;
use Illuminate\Http\JsonResponse;

class DeleteDashboardsController extends ApiAuthJsonController
{
    public function __invoke(Dashboard $dashboard, DeleteDashboardRequest $request): JsonResponse
    {
        $dashboard->delete();

        return $this->noContentResponse();
    }
}
