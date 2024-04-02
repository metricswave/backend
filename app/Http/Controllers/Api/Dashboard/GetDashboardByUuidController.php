<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\JsonController;
use App\Models\Dashboard;
use Illuminate\Http\JsonResponse;

class GetDashboardByUuidController extends JsonController
{
    public function __invoke(Dashboard $dashboard): JsonResponse
    {
        abort_if(! $dashboard->public, 404);

        return $this->response(
            $dashboard->toArray()
        );
    }
}
