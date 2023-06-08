<?php

namespace App\Services\Visits;

use Awssat\Visits\Visits as AwssatVisits;
use Illuminate\Support\Collection;
use Str;

class Visits extends AwssatVisits
{
    private string $period;

    public function recordParams(array $params, int $inc = 1): void
    {
        foreach ($params as $param => $value) {
            if (Str::of($value)->length() > 255) {
                continue;
            }

            $key = Str::of($param)->snake();

            foreach ($this->periods as $period) {
                $periodKey = $this->keys->period($period);
                $periodKey = "{$periodKey}_{$key}:{$this->keys->id}";

                $this->connection->increment($periodKey, $inc, $value);
                $this->connection->increment($periodKey.'_total', $inc, $value);
            }
        }
    }

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
