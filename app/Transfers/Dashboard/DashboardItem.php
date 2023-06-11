<?php

namespace App\Transfers\Dashboard;

use Spatie\LaravelData\Data;

class DashboardItem extends Data
{
    public function __construct(
        public string $eventUuid,
        public string $title,
        public DashboardItemSize $size,
        public DashboardItemType $type,
        public ?string $parameter = null,
    ) {
    }
}
