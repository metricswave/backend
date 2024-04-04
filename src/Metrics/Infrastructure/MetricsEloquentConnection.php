<?php

namespace MetricsWave\Metrics\Infrastructure;

use App\Services\CacheKey;
use Cache;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use MetricsWave\Metrics\Models\Visit;

class MetricsEloquentConnection implements MetricsConnection
{
    private const PREFIX = 'visits:';
    private int $year;

    public function __construct()
    {
        $this->year = now()->year;
    }

    public function all(
        string $period,
        string $key,
        $member = null,
        Carbon $from = null,
        Carbon $to = null
    ): Collection {
        return Cache::remember(
            CacheKey::generate('metrics:all', $key, [
                'period' => $period,
                'member' => $member,
                'from' => $from?->toDateString(),
                'to' => $to?->toDateString(),
            ]),
            Carbon::now()->addMinute(),
            fn () => $this->query()
                ->where('primary_key', self::PREFIX.$key)
                ->when(
                    (!empty($member) || is_numeric($member)),
                    fn($query) => $query->where('secondary_key', $member),
                )
                ->when(
                    $from !== null,
                    function ($q) use ($from) {
                        return $q->whereDate('expired_at', '>', $from);
                    }
                )
                ->when(
                    $to !== null,
                    function ($q) use ($to) {
                        return $q->whereDate('expired_at', '<=', $to);
                    }
                )
                ->when(
                    $from === null && $period === 'day',
                    function ($q) {
                        return $q->where(function ($q) {
                            return $q
                                ->whereDate(
                                    'expired_at',
                                    '>',
                                    Carbon::now()->subDays(30)->startOfDay()
                                )->orWhereNull('expired_at');
                        });
                    }
                )
                ->when($from === null && $period === 'month', function ($q) {
                    return $q->where(function ($q) {
                        return $q
                            ->whereDate(
                                'expired_at',
                                '>',
                                Carbon::now()->subMonths(12)->startOfMonth()
                            )
                            ->orWhereNull('expired_at');
                    });
                })
                ->orderByDesc('expired_at')
                ->get()
        );
    }

    public function get(string $key, int $member = null): int
    {
        $score = Cache::remember(
            'metrics:get:'.$key.':'.$member,
            Carbon::now()->addMinute(),
            fn() => $this->query()
                ->where('primary_key', self::PREFIX.$key)
                ->when(
                    (! empty($member) || is_numeric($member)),
                    fn ($query) => $query->where('secondary_key', $member),
                    fn ($query) => $query->whereNull('secondary_key')
                )
                ->where(function ($q) {
                    return $q->where('expired_at', '>', Carbon::now())
                        ->orWhereNull('expired_at');
                })
                ->value('score')
        );

        return intval($score);
    }

    public function delete(string $key, ?int $member = null): void
    {
        foreach ($this->tables() as $year) {
            $this->query($year)
                ->where('primary_key', self::PREFIX.$key)
                ->when(
                    (!empty($member) || is_numeric($member)),
                    fn($query) => $query->where('secondary_key', $member),
                    fn($query) => $query->whereNull('secondary_key')
                )
                ->delete();
        }
    }

    public function deleteByPrimary(string $key): void
    {
        do {
            foreach ($this->tables() as $year) {
                $deleted = $this->query($year)
                    ->where('primary_key', self::PREFIX.$key)
                    ->limit(1000)
                    ->delete();
            }
        } while ($deleted > 0);
    }

    /** @return array<int> */
    public function tables(): array
    {
        return [
            2024,
            2023, // or older
        ];
    }

    public function setYear(?int $year): self
    {
        $this->year = $year ?? now()->year;

        return $this;
    }

    private function query(?int $year = null): Builder
    {
        return (new Visit())
            ->setTableForYear($year ?? $this->year)
            ->setConnection(config('visits.connection'))
            ->newQuery();
    }

    public function allByParam(string $key, Carbon $date): Collection
    {
        return Cache::remember(
            'metrics:allByParam:'.$key.':'.$date->toDateString(),
            Carbon::now()->addMinute(),
            fn() => $this->query()
                ->where('primary_key', self::PREFIX.$key)
                ->whereDate('expired_at', $date)
                ->orderByDesc('expired_at')
                ->get(['secondary_key', 'score', 'expired_at'])
                ->map(function ($item) {
                    return [
                        'param' => $item->secondary_key, 'score' => $item->score,
                    ];
                }),
        );
    }

    public function increment(string $key, int $value, int $member = null): void
    {
        $row = $this
            ->query()
            ->where('primary_key', self::PREFIX.$key)
            ->when(
                (! empty($member) || is_numeric($member)),
                fn ($query) => $query->where('secondary_key', $member),
                fn ($query) => $query->whereNull('secondary_key')
            )
            ->whereNull('expired_at')
            ->first();

        if ($row === null) {
            $row = new Visit(
                (! empty($member) || is_numeric($member)) ?
                    ['primary_key' => self::PREFIX.$key, 'secondary_key' => $member] :
                    ['primary_key' => self::PREFIX.$key]
            );
            $row->setConnection(config('visits.connection'))->setTableForYear();
        }

        $row->score += $value;

        $row->save();
    }

    public function incrementWithExpiration(
        string $key,
        mixed $inc,
        mixed $id,
        int $expireInSeconds,
        int $attempt = 0
    ): void {
        $expiredAt = Carbon::now()->addSeconds($expireInSeconds);

        $secondaryKey = (! empty($id) || is_numeric($id)) ? $id : null;

        $row = $this->query()
            ->where('primary_key', self::PREFIX.$key)
            ->where('secondary_key', $secondaryKey)
            ->whereDate('expired_at', $expiredAt)
            ->first();

        if ($row === null) {
            $row = new Visit([
                'primary_key' => self::PREFIX.$key,
                'secondary_key' => $secondaryKey,
                'expired_at' => $expiredAt,
                'score' => 0,
            ]);
            $row->setConnection(config('visits.connection'))->setTableForYear();
        }

        $row->score += $inc;

        try {
            $row->save();
        } catch (UniqueConstraintViolationException $e) {
            if ($attempt >= 3) {
                throw $e;
            }

            sleep(10);
            $this->incrementWithExpiration($key, $inc, $id, $expireInSeconds, $attempt + 1);
        }
    }
}
