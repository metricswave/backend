<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\JsonController;
use App\Models\Dashboard;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;

class GetDashboardTriggersByUuidController extends JsonController
{
    public function __invoke(Dashboard $dashboard): JsonResponse
    {
        abort_if(!$dashboard->public, 404);

        $uuids = collect($dashboard->items->toArray())->pluck('eventUuid')->toArray();

        return $this->response(
            Trigger::whereIn('uuid', $uuids)->get()->toArray()
        );
    }
}
