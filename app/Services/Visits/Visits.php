<?php

namespace App\Services\Visits;

use Awssat\Visits\Visits as AwssatVisits;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Str;
use const SORT_NUMERIC;

/**
 * @property PermanentEloquentEngine $connection
 */
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

        $this->periodsParamsSync($params);
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

    private function periodsParamsSync(array $params): void
    {
        foreach ($params as $param => $value) {
            if (Str::of($value)->length() > 255) {
                continue;
            }

            $key = Str::of($param)->snake();

            foreach ($this->periods as $period) {
                $periodKey = $this->keys->period($period);
                $periodKey = "{$periodKey}_{$key}:{$this->keys->id}";

                $expireInSeconds = $this->newExpiration($period);
                $this->connection->setExpiration($periodKey, $expireInSeconds);
                $this->connection->setExpiration($periodKey.'_total', $expireInSeconds);
            }
        }
    }

    public function countAll(Carbon $from = null, Carbon $to = null): Collection
    {
        $key = $this->keys->visits;
        $id = $this->keys->id;

        $count = $this->connection->all($this->period, $key, $id, $from, $to);

        return $count->map(function ($item) {
            return [
                'score' => $item->score,
                'date' => $this->extractedDate($item, $this->period),
            ];
        });

    }

    private function extractedDate($item, string $period): Carbon
    {
        if ($item->expired_at === null) {
            return now()->startOf($period);
        }

        /** @var Carbon $date */
        $date = $item->expired_at;

        return $date->sub($period, 1, false);
    }

    public function countAllByParam(string $param, Carbon $date): Collection
    {
        $param = Str::of($param)->snake();
        $key = "{$this->keys->visits}_{$param}:{$this->keys->id}";

        return $this->connection->allByParam($key, $date)->sortByDesc('score', SORT_NUMERIC);
    }

    public function countAllByParamAndDate(string $param, Carbon $from, Carbon $to): Collection
    {
        $param = Str::of($param)->snake();
        $key = "{$this->keys->visits}_{$param}:{$this->keys->id}";

        $count = $this->connection->all($this->period, $key, null, $from, $to);

        return $count
            ->groupBy(fn($item) => $item->secondary_key)
            ->map(fn($item, $key) => [
                'score' => $item->sum('score'),
                'param' => $key,
            ])
            ->sortByDesc('score', SORT_NUMERIC)
            ->values();
    }
}
