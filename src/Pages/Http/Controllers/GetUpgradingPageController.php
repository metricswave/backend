<?php

namespace MetricsWave\Pages\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Plans\PlanGetter;
use App\Transfers\PlanId;
use Illuminate\View\View;
use MetricsWave\Teams\Team;

class GetUpgradingPageController extends Controller
{
    public function __invoke(int $teamId): View
    {
        $team = Team::findOrFail($teamId);

        return view('pages.upgrading', [
            'team' => $team,
        ]);
    }
}
