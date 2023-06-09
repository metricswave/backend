<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class GetTriggerParameterStatsController extends ApiAuthJsonController
{
    public function __invoke(Trigger $trigger): JsonResponse
    {
        if ($trigger->user_id !== $this->user()->id) {
            abort(404);
        }

        if (!isset($trigger->configuration['parameters'])) {
            return $this->response([]);
        }

        $period = request()->query('period') ?? 'day';

        if (request()->query('date')) {
            $date = Carbon::createFromFormat('Y-m-d', request()->query('date'))->startOfDay();
        } else {
            $date = null;
        }

        $response = [];
        foreach ($trigger->configuration['parameters'] as $parameter) {
            $response[$parameter] = $trigger->visits()->period($period)->countAllByParam($parameter, $date);
        }

        return $this->response($response);
    }
}
