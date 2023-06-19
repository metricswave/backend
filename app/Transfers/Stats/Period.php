<?php

namespace App\Transfers\Stats;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class Period extends Data
{
    readonly public string $date;

    public function __construct(
        Carbon $date,
        readonly public PeriodEnum $period,
    ) {
        $this->date = $date->startOf($this->period->visitsPeriod())->format('Y-m-d');
    }

    public function fromDate(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', $this->date)
            ->subDays($this->period->days())
            ->startOfDay();
    }

    public function toDate(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', $this->date)
            ->addDay()
            ->startOfDay();
    }
}
