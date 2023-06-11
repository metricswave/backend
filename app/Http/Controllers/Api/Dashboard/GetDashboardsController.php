<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;

class GetDashboardsController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        $this->createDefaultIfUserHasNotAny();

        return $this->response(
            $this->user()->dashboards()->get()->toArray()
        );
    }

    private function createDefaultIfUserHasNotAny(): void
    {
        if ($this->user()->dashboards->isEmpty()) {
            $this->user()->dashboards()->create([
                'name' => 'Default',
                'items' => [],
            ]);
        }
    }
}
