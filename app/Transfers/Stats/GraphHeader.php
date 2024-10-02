<?php

namespace App\Transfers\Stats;

use Spatie\LaravelData\Data;

class GraphHeader extends Data
{
    public function __construct(
        public string $label,
        public int $value,
    ) {}
}
