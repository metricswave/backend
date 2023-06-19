<?php

namespace App\Transfers\Stats;

use Exception;

enum PeriodEnum: string
{
    case weekInDays = '7d';
    case monthInDays = '30d';
    case yearInDays = '12m';
    case month = 'month';
    case year = 'year';

    public function days(): int
    {
        return match ($this) {
            self::weekInDays => 7,
            self::monthInDays => 30,
            self::yearInDays => 365,
            self::month => now()->startOfMonth()->diffInDays(),
            self::year => now()->startOfYear()->diffInDays(),
            default => throw new Exception('Invalid period'),
        };
    }

    public function visitsPeriod(): string
    {
        return match ($this) {
            self::weekInDays, self::monthInDays, self::month => 'day',
            self::yearInDays, self::year => 'month',
            default => throw new Exception('Invalid period'),
        };
    }

    public function visitsHeaderPeriod(): string
    {
        return match ($this) {
            self::weekInDays => 'week',
            self::monthInDays, self::month => 'month',
            self::yearInDays, self::year => 'year',
            default => throw new Exception('Invalid period'),
        };
    }
}
