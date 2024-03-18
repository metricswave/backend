<?php

namespace App\Transfers\Stats;

use Illuminate\Support\Carbon;

interface PeriodInterface
{
    public function __construct(Carbon $date, PeriodEnum $period, ?Carbon $fromDate = null);

    public function fromDate(): Carbon;

    public function toDate(): Carbon;

    public function toArray(): array;
}
