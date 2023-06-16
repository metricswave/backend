<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\PutDashboardRequest;
use App\Models\Dashboard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PutDashboardsController extends ApiAuthJsonController
{
    public function __invoke(Dashboard $dashboard, PutDashboardRequest $request): JsonResponse
    {
        $fields = $request->validated();

        if ($dashboard->uuid === null) {
            $fields['uuid'] = Str::random(15);
        }

        $dashboard->update($fields);

        return $this->noContentResponse();
    }
}
