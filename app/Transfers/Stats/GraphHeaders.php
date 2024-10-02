<?php

namespace App\Transfers\Stats;

use Spatie\LaravelData\Data;

/**
 * @property GraphData[] $data
 */
class GraphHeaders extends Data
{
    public function __construct(
        readonly public array $data,
    ) {}

    public function toArray(): array
    {
        return collect($this->data)
            ->mapWithKeys(fn (GraphHeader $header) => [$header->label => $header->value])
            ->toArray();
    }
}
