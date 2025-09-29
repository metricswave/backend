<?php

namespace App\Http\Controllers\Open;

use App\Models\User;
use MetricsWave\Teams\Team;

trait HasOpenData
{
    private const MULTIPLIER = 9;

    public function getOpenData(): array
    {
        $previousUserData = $this->getOpenUserData();

        return [
            'notifications' => [
                'daily' => format_long_numbers(
                    $this->getTeamVisitsInPeriod('day') + $previousUserData['notifications']['daily'],
                ),
                'weekly' => format_long_numbers(
                    $this->getTeamVisitsInPeriod('week') + $previousUserData['notifications']['weekly'],
                ),
                'monthly' => format_long_numbers(
                    $this->getTeamVisitsInPeriod('month') + $previousUserData['notifications']['monthly'],
                ),
                'yearly' => format_long_numbers(
                    $this->getTeamVisitsInPeriod('year')
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

    private function getTeamVisitsInPeriod(string $period): int
    {
        return visitsService(Team::class, Team::TRIGGER_NOTIFICATION, withCache: false)
            ->period($period)
            ->count() * self::MULTIPLIER;
    }
}
