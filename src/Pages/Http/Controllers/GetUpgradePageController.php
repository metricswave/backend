<?php

namespace MetricsWave\Pages\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use MetricsWave\Teams\Team;

class GetUpgradePageController extends Controller
{
    public function __invoke(int $teamId): View
    {
        $team = Team::findOrFail($teamId);

        return view('pages.upgrade', [
            'team' => $team,
        ]);
    }
}
