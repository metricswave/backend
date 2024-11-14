<?php

namespace MetricsWave\Metrics\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $connection = 'visits';

    protected $guarded = [];

    protected $casts = ['list' => 'array', 'expired_at' => 'datetime'];

    public function setTableForYear(int $year = null): self
    {
        return $this->setTable(
            self::tableNameForYear($year)
        );
    }

    public static function tableNameForYear(?int $year): string
    {
        $year = $year ?? now()->year;

        return match (true) {
            $year < 2024 => 'visits_old',
            default => config('visits.table_without_year').$year,
        };
    }

    /** @return array<string> */
    public static function tables(): array
    {
        $tables = ['visits_old'];

        $currentYear = now()->year;

        // Loop from 2024 to the current year and add each year to the array
        for ($year = 2024; $year <= $currentYear; $year++) {
            $tables[] = config('visits.table_without_year').$year;
        }

        return $tables;
    }
}
