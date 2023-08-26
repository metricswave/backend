<?php

namespace MetricsWave\Metrics;

use App\Services\Visits\VisitsInterface;
use Awssat\Visits\Keys;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MetricsWave\Metrics\Infrastructure\MetricsEloquentConnection;

class Metrics implements VisitsInterface
{
    private const PERIODS = [
        'day',
        'week',
        'month',
        'year',
    ];

    private Keys $keys;

    private string $period;

    private MetricsEloquentConnection $connection;

    public function __construct(
        Model $subject,
        string $tag,
    ) {
        $this->keys = new Keys($subject, preg_replace('/[^a-z0-9_]/i', '', $tag));
        $this->connection = new MetricsEloquentConnection();
    }

    public function count(): int
    {
        return $this->keys->instanceOfModel
            ? $this->connection->get($this->keys->visits, $this->keys->id)
            : $this->connection->get($this->keys->visitsTotal());
    }

    public function countAll(Carbon $from = null, Carbon $to = null): Collection
    {
        $count = $this->connection
            ->all($this->period, $this->keys->visits, $this->keys->id, $from, $to)
            ->map(function ($item) {
                return [
                    'score' => $item->score,
                    'date' => $this->extractedDate($item, $this->period),
                ];
            });

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

        return $this->connection->allByParam($key, $date)->sortByDesc('score', SORT_NUMERIC);
    }

    public function countAllByParamAndDate(string $param, Carbon $from, Carbon $to): Collection
    {
        $param = Str::of($param)->snake();
        $key = "{$this->keys->visits}_{$param}:{$this->keys->id}";

        $count = $this->connection->all($this->period, $key, null, $from, $to);

        return $count
            ->groupBy(fn ($item) => $item->secondary_key)
            ->map(fn ($item, $key) => [
                'score' => $item->sum('score'),
                'param' => $key,
            ])
            ->sortByDesc('score', SORT_NUMERIC)
            ->values();
    }

    public function increment($inc = 1): void
    {
        $this->connection->increment($this->keys->visits, $inc, $this->keys->id);
        $this->connection->increment($this->keys->visitsTotal(), $inc);

        foreach (self::PERIODS as $period) {
            $expireInSeconds = $this->newExpiration($period);
            $periodKey = $this->keys->period($period);

            $this->connection->incrementWithExpiration($periodKey, $inc, $this->keys->id, $expireInSeconds);
            $this->connection->incrementWithExpiration($periodKey.'_total', $inc, null, $expireInSeconds);
        }
    }

    protected function newExpiration($period): int
    {
        try {
            $periodCarbon = $this->xHoursPeriod($period) ?? Carbon::now()->{'endOf'.Str::studly($period)}();
        } catch (Exception $e) {
            throw new Exception("Wrong period: `{$period}`! please update config/visits.php file.");
        }

        return $periodCarbon->diffInSeconds() + 1;
    }

    protected function xHoursPeriod($period)
    {
        preg_match('/([\d]+)\s?([\w]+)/', $period, $match);

        return isset($match[2]) && isset($match[1]) && $match[2] == 'hours' && $match[1] < 12
            ? Carbon::now()->endOfxHours((int) $match[1])
            : null;
    }

    public function period(string $period): static
    {
        $this->period = $period;
        $this->keys->visits = $this->keys->period($period);

        return $this;
    }

    public function recordParams(array $params, int $inc = 1): void
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
                $expireInSeconds = $this->newExpiration($period);

                $this->connection->incrementWithExpiration($periodKey, $inc, $value, $expireInSeconds);
                $this->connection->incrementWithExpiration($periodKey.'_total', $inc, $value, $expireInSeconds);
            }
        }
    }
}
