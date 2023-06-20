<?php

namespace App\Transfers\Stats;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class Period extends Data implements PeriodInterface
{
    readonly public Carbon $date;
    readonly public array $periodDates;

    public function __construct(
        Carbon $date,
        readonly public PeriodEnum $period,
    ) {
        $this->date = $date
            ->add($this->period->visitsPeriod(), 1)
            ->startOf($this->period->visitsPeriod());
        $this->periodDates = [
            'from' => $this->fromDate()->toDateString(),
            'to' => $this->toDate()->toDateString(),
        ];
    }

    public function fromDate(): Carbon
    {
        return $this->date->clone()
            ->subDays($this->period->days($this->date))
            ->startOfDay();
    }

    public function toDate(): Carbon
    {
        return $this->date->clone()
            ->startOfDay()
            ->clone();
    }
}
