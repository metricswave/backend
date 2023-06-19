<?php

namespace App\Transfers\Stats;

use Spatie\LaravelData\Data;

class ParameterData extends Data
{
    public function __construct(
        readonly public string $value,
        readonly public int $score,
    ) {
    }
}
