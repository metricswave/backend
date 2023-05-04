<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Trigger;
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
        return view('open.open', [
            'leadsCount' => Lead::count(),
            'triggersCount' => Trigger::count(),
            'notifications' => [
                'weekly' => visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('week')->count(),
                'monthly' => visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('month')->count(),
            ],
            'income' => Lead::sum('paid_price'),
            'prices' => ($this->landingPricesService)(),
        ]);
    }
}
