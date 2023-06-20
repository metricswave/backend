<?php

namespace App\Transfers\Stats;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class Period extends Data implements PeriodInterface
{
    readonly public Carbon $date;

    public function __construct(
        Carbon $date,
        readonly public PeriodEnum $period,
    ) {
        $this->date = $date
            ->add($this->period->visitsPeriod(), 1)
            ->startOf($this->period->visitsPeriod());
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date->format('Y-m-d'),
            'period' => $this->period->value,
            [
                'from' => $this->fromDate()->format('Y-m-d'),
                'to' => $this->toDate()->format('Y-m-d'),
            ]
        ];
    }

    public function fromDate(): Carbon
    {
        return $this->date->clone()
            ->subDays($this->period->days())
            ->startOfDay();
    }

    public function toDate(): Carbon
    {
        return $this->date->clone()
            ->startOfDay()
            ->clone();
    }
}
