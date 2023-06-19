<?php

namespace App\Transfers\Stats;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class GraphData extends Data
{
    public function __construct(
        readonly public Carbon $date,
        readonly public int $score,
    ) {
    }
}
