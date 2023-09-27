<?php

namespace App\Http\Controllers\Open;

use MetricsWave\Teams\Team;
use MetricsWave\Users\User;

trait HasOpenData
{
    public function getOpenData(): array
    {
        $previousUserData = $this->getOpenUserData();

        $firstDayWithStats = now()->year === 2023 ? 126 : 0;
        $yearlyEstimation = (
            visitsService(Team::class, Team::TRIGGER_NOTIFICATION)->period('year')->count()
            / (now()->dayOfYear - $firstDayWithStats)
            * 365
        );

        return [
            'notifications' => [
                'weekly' => format_long_numbers(
                    visitsService(Team::class, Team::TRIGGER_NOTIFICATION)->period('week')->count()
                    + $previousUserData['notifications']['weekly']
                ),
                'monthly' => format_long_numbers(
                    visitsService(Team::class, Team::TRIGGER_NOTIFICATION)->period('month')->count()
                    + $previousUserData['notifications']['monthly']
                ),
                'yearly' => format_long_numbers(
                    $yearlyEstimation + $previousUserData['notifications']['yearly']
                ),
            ],
        ];
    }

    public function getOpenUserData(): array
    {
        $firstDayWithStats = now()->year === 2023 ? 126 : 0;
        $yearlyEstimation = (
            visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('year')->count()
            / (now()->dayOfYear - $firstDayWithStats)
            * 365
        );

        return [
            'notifications' => [
                'weekly' => visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('week')->count(),
                'monthly' => visitsService(User::class, User::TRIGGER_NOTIFICATION)->period('month')->count(),
                'yearly' => $yearlyEstimation,
            ],
        ];
    }
}
