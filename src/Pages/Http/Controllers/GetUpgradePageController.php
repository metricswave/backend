<?php

namespace MetricsWave\Pages\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Plans\PlanGetter;
use App\Transfers\PlanId;
use Illuminate\View\View;
use MetricsWave\Teams\Team;

class GetUpgradePageController extends Controller
{
    public function __construct(private readonly PlanGetter $planGetter)
    {
    }

    public function __invoke(int $teamId): View
    {
        $team = Team::findOrFail($teamId);

        if ($team->subscription_plan_id !== PlanId::FREE) {
            return view('pages.team_upgraded', [
                'team' => $team,
                'plan' => $this->planGetter->get($team->subscription_plan_id),
            ]);
        }

        return view('pages.upgrade', [
            'team' => $team,
        ]);
    }
}
