<?php

namespace App\Transfers\Stats;

use Spatie\LaravelData\Data;

class ParametersGraphDataCollection extends Data
{
    public function __construct(
        readonly public PeriodInterface $period,
        readonly public array $plot,
    ) {
    }
}
