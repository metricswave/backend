<?php

namespace MetricsWave\Metrics;

use Carbon\CarbonInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MetricsWave\Metrics\Infrastructure\MetricsEloquentConnection;

class Metrics implements MetricsInterface
{
    private const PERIODS = [
        'day',
        'week',
        'month',
        'year',
    ];

    private MetricsKeys $keys;

    private string $period;

    private MetricsEloquentConnection $connection;

    public function __construct(
        string|Model $subject,
        string $tag,
        bool $useCache = true,
    ) {
        $this->keys = new MetricsKeys($subject, preg_replace('/[^a-z0-9_]/i', '', $tag));
        $this->connection = new MetricsEloquentConnection($useCache);
    }

    public function count(): int
    {
        return $this->keys->instanceOfModel
            ? $this->connection->get($this->keys->visits, $this->keys->id)
            : $this->connection->get($this->keys->visitsTotal());
    }

    private function yearsInPeriod(Carbon $from = null, Carbon $to = null)
    {
        $from = $from ?? now();
        $to = $to ?? now();

        return range(
            max(2023, $from->year),
            $to->year,
        );
    }

    public function countAll(Carbon $from = null, Carbon $to = null): Collection
    {
        $count = collect();

        foreach ($this->yearsInPeriod($from, $to) as $year) {
            $count = $count->merge(
                $this->connection
                    ->setYear($year)
                    ->all(
                        $this->period,
                        $this->keys->instanceOfModel ? $this->keys->visits : $this->keys->visitsTotal(),
                        $this->keys->id,
                        $from,
                        $to,
                    )
                    ->map(function ($item) {
                        return [
                            'score' => $item->score,
                            'date' => $this->extractedDate($item, $this->period),
                        ];
                    })
            );
        }

        if ($from !== null && $to !== null) {
            $count = $this->fillMissingDates($count, $from, $to);
        }

        return $count;
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

    private function fillMissingDates(
        \Illuminate\Database\Eloquent\Collection|array|Collection $count,
        Carbon $from,
        Carbon $to
    ) {
        $dates = $this->getDatesBetween($from, $to);
        $count = $count->keyBy(fn ($item) => $item['date']->toDateString());

        $count = $dates->map(function ($date) use ($count) {
            $dateString = $date->toDateString();

            if ($count->has($dateString)) {
                return $count->get($dateString);
            }

            return [
                'score' => 0,
                'date' => $date,
            ];
        });

        return $count->values();
    }

    private function getDatesBetween(Carbon $from, Carbon $to): Collection
    {
        $dates = collect();

        while ($from->lt($to)) {
            $dates->push($from->copy());
            $from->add($this->period, 1);
        }

        return $dates;
    }

    public function countAllByParam(string $param, Carbon $date): Collection
    {
        $param = Str::of($param)->snake();
        $key = "{$this->keys->visits}_{$param}:{$this->keys->id}";

        return $this->connection
            ->setYear($date->year)
            ->allByParam($key, $date)
            ->sortByDesc('score', SORT_NUMERIC);
    }

    public function countAllByParamAndDate(string $param, Carbon $from, Carbon $to): Collection
    {
        $param = Str::of($param)->snake();
        $key = "{$this->keys->visits}_{$param}:{$this->keys->id}";

        $count = collect();

        foreach ($this->yearsInPeriod($from, $to) as $year) {
            $count = $count->merge(
                $this->connection->setYear($year)->all($this->period, $key, null, $from, $to)
            );
        }

        return $count
            ->groupBy(fn ($item) => $item->secondary_key)
            ->map(fn ($item, $key) => [
                'score' => $item->sum('score'),
                'param' => $key,
            ])
            ->sortByDesc('score', SORT_NUMERIC)
            ->values();
    }

    public function increment($inc = 1, CarbonInterface $date = null): void
    {
        $this->connection
            ->setYear(null)
            ->increment($this->keys->visits, $inc, $this->keys->id);
        $this->connection
            ->setYear(null)
            ->increment($this->keys->visitsTotal(), 1);

        foreach (self::PERIODS as $period) {
            $expireInSeconds = $this->newExpiration($period, $date);
            $periodKey = $this->keys->period($period);

            $this->connection
                ->setYear(null)
                ->incrementWithExpiration($periodKey, $inc, $this->keys->id, $expireInSeconds);
            $this->connection
                ->setYear(null)
                ->incrementWithExpiration($periodKey.'_total', 1, null, $expireInSeconds);
        }
    }

    protected function newExpiration($period, CarbonInterface $date = null): int
    {
        try {
            $date = $date ?? Carbon::now();
            $periodCarbon = $this->xHoursPeriod($period, $date) ?? $date->{'endOf'.Str::studly($period)}();
        } catch (Exception $e) {
            throw new Exception("Wrong period: `{$period}`! please update config/visits.php file.");
        }

        return Carbon::now()->diffInSeconds($periodCarbon, absolute: false) + 1;
    }

    protected function xHoursPeriod($period, CarbonInterface $date = null)
    {
        $date = $date ?? Carbon::now();

        preg_match('/([\d]+)\s?([\w]+)/', $period, $match);

        return isset($match[2]) && isset($match[1]) && $match[2] == 'hours' && $match[1] < 12
            ? $date->endOfxHours((int) $match[1])
            : null;
    }

    public function period(string $period): static
    {
        $this->period = $period;
        $this->keys->visits = $this->keys->period($period);

        return $this;
    }

    public function recordParams(array $params, int $inc = 1, CarbonInterface $date = null): void
    {
        foreach ($params as $param => $value) {
            if (Str::of($value)->length() > 255) {
                continue;
            }

            if (empty($value) || $value === 'null') {
                if (Str::of($param)->startsWith('utm_')) {
                    $value = 'Direct / None';
                } else {
                    continue;
                }
            }

            $key = Str::of($param)->snake();

            foreach (self::PERIODS as $period) {
                $periodKey = $this->keys->period($period);
                $periodKey = "{$periodKey}_{$key}:{$this->keys->id}";
                $expireInSeconds = $this->newExpiration($period, $date);

                $this->connection
                    ->setYear(null)
                    ->incrementWithExpiration($periodKey, $inc, $value, $expireInSeconds);
                $this->connection
                    ->setYear(null)
                    ->incrementWithExpiration($periodKey.'_total', $inc, $value, $expireInSeconds);
            }
        }
    }

    public function delete(): void
    {
        $this->connection->delete($this->keys->visits, $this->keys->id);
        $this->connection->delete($this->keys->visitsTotal());

        foreach (self::PERIODS as $period) {
            $periodKey = $this->keys->period($period);
            $this->connection->delete($periodKey, $this->keys->id);
            $this->connection->delete($periodKey.'_total');
        }
    }

    /**
     * @param  array<string>  $params
     */
    public function deleteParams(array $params): void
    {
        foreach ($params as $param) {
            $key = Str::of($param)->snake();

            foreach (self::PERIODS as $period) {
                $periodKey = $this->keys->period($period);
                $periodKey = "{$periodKey}_{$key}:{$this->keys->id}";

                $this->connection->deleteByPrimary($periodKey);
                $this->connection->deleteByPrimary($periodKey.'_total');
            }
        }

    }
}
