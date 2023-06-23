<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Prices\GetLandingPricesService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class GetOpenPageController extends Controller
{
    public function __construct(public readonly GetLandingPricesService $landingPricesService)
    {
    }

    public function __invoke(): View|Factory
    {
        $monthlyCount = visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('month')->count();
        return view('open.open', [
            // 'leadsCount' => Lead::count(),
            // 'triggersCount' => Trigger::count(),
            'notifications' => [
                'weekly' => $this->formatLongNumbers(
                    visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('week')->count()
                ),
                'monthly' => $this->formatLongNumbers($monthlyCount),
                'yearly' => $this->formatLongNumbers($monthlyCount * 12),
            ],
            // 'income' => Lead::sum('paid_price'),
        ]);
    }

    public function formatLongNumbers($n, $precision = 3): string
    {
        if ($n < 1000000) {
            return number_format($n);
        }

        // Anything less than a billion
        if ($n < 1000000000) {
            return number_format($n / 1000000, $precision).'M';
        }

        // At least a billion
        return number_format($n / 1000000000, $precision).'B';
    }
}
