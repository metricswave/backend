<?php

namespace MetricsWave\Metrics\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $connection = 'visits';

    protected $guarded = [];

    protected $casts = ['list' => 'array', 'expired_at' => 'datetime'];

    public function setTableForYear(?int $year = null): self
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
            default => config('visits.table'),
        };
    }

    /** @return array<string> */
    public static function tables(): array
    {
        return ['visits_old', config('visits.table')];
    }
}
