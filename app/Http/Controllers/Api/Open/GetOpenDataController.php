<?php

namespace App\Http\Controllers\Api\Open;

use App\Http\Controllers\Api\JsonController;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class GetOpenDataController extends JsonController
{
    public function __invoke(): JsonResponse
    {
        $firstDayWithStats = now()->year === 2023 ? 126 : 0;
        $yearlyEstimation = (
            visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('year')->count()
            / (now()->dayOfYear - $firstDayWithStats)
            * 365
        );

        return $this->response([
            'notifications' => [
                'weekly' => format_long_numbers(
                    visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('week')->count()
                ),
                'monthly' => format_long_numbers(
                    visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('month')->count()
                ),
                'yearly' => format_long_numbers(
                    $yearlyEstimation
                ),
            ],
        ]);

    }
}
