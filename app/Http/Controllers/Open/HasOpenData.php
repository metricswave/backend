<?php

namespace App\Http\Controllers\Open;

use App\Models\User;
use MetricsWave\Teams\Team;

trait HasOpenData
{
    public function getOpenData(): array
    {
        $previousUserData = $this->getOpenUserData();

        return [
            'notifications' => [
                'daily' => format_long_numbers(
                    visitsService(Team::class, Team::TRIGGER_NOTIFICATION, withCache: false)
                        ->period('day')
                        ->count()
                        + $previousUserData['notifications']['daily'],
                ),
                'weekly' => format_long_numbers(
                    visitsService(Team::class, Team::TRIGGER_NOTIFICATION, withCache: false)
                        ->period('week')
                        ->count()
                    + $previousUserData['notifications']['weekly'],
                ),
                'monthly' => format_long_numbers(
                    visitsService(Team::class, Team::TRIGGER_NOTIFICATION, withCache: false)
                        ->period('month')
                        ->count()
                    + $previousUserData['notifications']['monthly'],
                ),
                'yearly' => format_long_numbers(
                    visitsService(Team::class, Team::TRIGGER_NOTIFICATION, withCache: false)
                        ->period('year')
                        ->count()
                    + $previousUserData['notifications']['yearly'],
                ),
            ],
        ];
    }

    public function getOpenUserData(): array
    {
        return [
            'notifications' => [
                'daily' => visitsService(User::class, User::TRIGGER_NOTIFICATION, withCache: false)
                    ->period('day')
                    ->count(),
                'weekly' => visitsService(User::class, User::TRIGGER_NOTIFICATION, withCache: false)
                    ->period('week')
                    ->count(),
                'monthly' => visitsService(User::class, User::TRIGGER_NOTIFICATION, withCache: false)
                    ->period('month')
                    ->count(),
                'yearly' => visitsService(User::class, User::TRIGGER_NOTIFICATION, withCache: false)
                    ->period('year')
                    ->count(),
            ],
        ];
    }
}
