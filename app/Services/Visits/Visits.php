<?php

namespace App\Services\Visits;

use Awssat\Visits\Visits as AwssatVisits;
use Illuminate\Support\Collection;

class Visits extends AwssatVisits
{
    private string $period;

    public function period($period): Visits|static
    {
        $this->period = $period;
        return parent::period($period);
    }

    public function increment($inc = 1, $force = true, $ignore = []): bool
    {
        $response = parent::increment($inc, $force, $ignore);
        $this->periodsSync();

        return $response;
    }

    public function countAll(): Collection
    {
        $key = $this->keys->visits;
        $id = $this->keys->id;

        return $this->connection->all($this->period, $key, $id);
    }
}
