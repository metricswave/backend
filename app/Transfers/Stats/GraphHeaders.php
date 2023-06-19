<?php

namespace App\Transfers\Stats;

use Spatie\LaravelData\Data;

class GraphHeaders extends Data
{
    public function __construct(
        readonly public int $unique,
        readonly public int $visits,
        readonly public int $pageViews,
    ) {
    }
}
