<?php

namespace App\Transfers\Stats;

use Exception;
use Illuminate\Support\Carbon;

enum PeriodEnum: string
{
    case day = 'day';
    case weekInDays = '7d';
    case monthInDays = '30d';
    case yearInDays = '12m';
    case month = 'month';
    case year = 'year';

    public function days(Carbon $date): int
    {
        return match ($this) {
            self::day => 1,
            self::weekInDays => 7,
            self::monthInDays => 30,
            self::yearInDays => 365,
            self::month => $date->clone()->daysInMonth,
            self::year => $date->clone()->daysInYear,
            default => throw new Exception('Invalid period'),
        };
    }

    public function visitsPeriodInterval(): string
    {
        return match ($this) {
            self::day, self::weekInDays, self::monthInDays, self::month => 'day',
            self::yearInDays, self::year => 'month',
            default => throw new Exception('Invalid period'),
        };
    }

    public function visitsPeriod(): string
    {
        return match ($this) {
            self::day, self::weekInDays, self::monthInDays => 'day',
            self::yearInDays, self::month => 'month',
            self::year => 'year',
            default => throw new Exception('Invalid period'),
        };
    }
}
