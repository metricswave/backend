<?php

namespace App\Transfers\Stats;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Statamic\Data\DataCollection;

class GraphDataCollection extends Data
{
    public function __construct(
        readonly public Period $period,
        readonly public ?GraphHeaders $headers,
        #[DataCollectionOf(GraphData::class)]
        readonly public DataCollection $plot,
    ) {
    }
}
