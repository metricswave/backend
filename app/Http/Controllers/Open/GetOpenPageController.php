<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class GetOpenPageController extends Controller
{
    public function __invoke(): View|Factory
    {
        $firstDayWithStats = now()->year === 2023 ? 126 : 0;
        $yearlyEstimation = (
            visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('year')->count()
            / (now()->dayOfYear - $firstDayWithStats)
            * 365
        );

        return view('open.open', [
            'notifications' => [
                'weekly' => $this->formatLongNumbers(
                    visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('week')->count()
                ),
                'monthly' => $this->formatLongNumbers(
                    visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('month')->count()
                ),
                'yearly' => $this->formatLongNumbers(
                    $yearlyEstimation
                ),
            ],
        ]);
    }

    public function formatLongNumbers($n, $precision = 3): string
    {
        return format_long_numbers($n, $precision);
    }
}
