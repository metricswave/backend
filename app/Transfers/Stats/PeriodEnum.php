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

    case customDaily = 'c_daily';
    case customMonthy = 'c_monthly';

    public static function default(): self
    {
        return self::monthInDays;
    }

    public function days(Carbon $date): ?int
    {
        return match ($this) {
            self::day => 1,
            self::weekInDays => 7,
            self::monthInDays => 30,
            self::yearInDays => 365,
            self::month => $date->clone()->subMonthNoOverflow()->daysInMonth,
            self::year => $date->clone()->subYearNoOverflow()->daysInYear,
            self::customMonthy, self::customDaily => null,
            default => throw new Exception('Invalid period'),
        };
    }

    public function visitsPeriodInterval(): string
    {
        return match ($this) {
            self::day, self::weekInDays, self::monthInDays, self::month, self::customDaily => 'day',
            self::customMonthy, self::yearInDays, self::year => 'month',
            default => throw new Exception('Invalid period'),
        };
    }

    public function visitsPeriod(): string
    {
        return match ($this) {
            self::day, self::weekInDays, self::monthInDays, self::customDaily => 'day',
            self::yearInDays, self::month, self::customMonthy => 'month',
            self::year => 'year',
            default => throw new Exception('Invalid period'),
        };
    }

    public function isCustom(): bool
    {
        return match ($this) {
            self::customMonthy, self::customDaily => true,
            default => false,
        };
    }
}
