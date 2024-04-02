<?php

namespace App\Transfers\Stats;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class Period extends Data implements PeriodInterface
{
    public readonly Carbon $date;

    public readonly array $periodDates;

    public function __construct(
        Carbon $date,
        readonly public PeriodEnum $period,
        readonly public ?Carbon $fromDate = null,
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
        return ($this->fromDate ?? $this->date)
            ->clone()
            ->subDays($this->period->days($this->date))
            ->startOf($this->period->visitsPeriod());
    }

    public function toDate(): Carbon
    {
        return $this->date->clone();
    }
}
