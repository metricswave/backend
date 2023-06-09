<?php

namespace App\Services\Visits;

use Awssat\Visits\DataEngines\DataEngine;
use Awssat\Visits\Models\Visit as Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class PermanentEloquentEngine implements DataEngine
{
    private $model = null;
    private $prefix = null;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function connect(string $connection): DataEngine
    {
        return $this;
    }

    public function setPrefix(string $prefix): DataEngine
    {
        $this->prefix = $prefix.':';
        return $this;
    }

    public function decrement(string $key, int $value, $member = null): bool
    {
        return $this->increment($key, -$value, $member);
    }

    public function increment(string $key, int $value, $member = null): bool
    {
        if (!empty($member) || is_numeric($member)) {
            $row = $this->model
                ->where(fn(Builder $query) => $query
                    ->whereDate('expired_at', '>', now())
                    ->orWhereNull('expired_at')
                )
                ->firstOrNew([
                    'primary_key' => $this->prefix.$key, 'secondary_key' => $member
                ]);
        } else {
            $row = $this->model
                ->where(fn(Builder $query) => $query
                    ->whereDate('expired_at', '>', now())
                    ->orWhereNull('expired_at')
                )
                ->firstOrNew([
                    'primary_key' => $this->prefix.$key, 'secondary_key' => null
                ]);
        }

        if ($row->expired_at !== null && Carbon::now()->gt($row->expired_at)) {
            $row->score = $value;
            $row->expired_at = null;
        } else {
            $row->score += $value;
        }

        return $row->save();
    }

    public function all(string $period, string $key, $member = null)
    {
        if (!empty($member) || is_numeric($member)) {
            $query = $this->model->where(['primary_key' => $this->prefix.$key, 'secondary_key' => $member]);
        } else {
            $query = $this->model->where(['primary_key' => $this->prefix.$key]);
        }

        return $query
            ->when($period === 'day', function ($q) {
                return $q->where(function ($q) {
                    return $q->whereDate('expired_at', '>',
                        Carbon::now()->subDays(30)->startOfDay())->orWhereNull('expired_at');
                });
            })
            ->when($period === 'month', function ($q) {
                return $q->where(function ($q) {
                    return $q->whereDate('expired_at', '>',
                        Carbon::now()->subMonths(12)->startOfMonth())->orWhereNull('expired_at');
                });
            })
            ->orderByDesc('expired_at')
            ->get(['score', 'expired_at'])
            ->map(function ($item) use ($period) {
                return [
                    'score' => $item->score,
                    'date' => $this->extractedDate($item, $period),
                ];
            });
    }

    public function get(string $key, $member = null)
    {
        if (!empty($member) || is_numeric($member)) {
            return $this->model->where(['primary_key' => $this->prefix.$key, 'secondary_key' => $member])
                ->where(function ($q) {
                    return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
                })
                ->value('score');
        } else {
            return $this->model->where(['primary_key' => $this->prefix.$key, 'secondary_key' => null])
                ->where(function ($q) {
                    return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
                })
                ->value('score');
        }
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

    public function allByParam(string $key, ?Carbon $date): Collection
    {
        return $this->model
            ->where(['primary_key' => $this->prefix.$key])
            ->whereDate('expired_at', $date)
            ->orderByDesc('expired_at')
            ->get(['secondary_key', 'score', 'expired_at'])
            ->map(function ($item) {
                return [
                    'param' => $item->secondary_key,
                    'score' => $item->score,
                ];
            });
    }

    public function set(string $key, $value, $member = null): bool
    {
        if (!empty($member) || is_numeric($member)) {
            return $this->model->updateOrCreate([
                    'primary_key' => $this->prefix.$key,
                    'secondary_key' => $member,
                    'score' => $value,
                    'expired_at' => null,
                ]) instanceof Model;
        } else {
            return $this->model->updateOrCreate([
                    'primary_key' => $this->prefix.$key,
                    'score' => $value,
                    'expired_at' => null,
                ]) instanceof Model;
        }
    }

    public function search(string $word, bool $noPrefix = true): array
    {
        $results = [];

        if ($word == '*') {
            $results = $this->model
                ->where(function ($q) {
                    return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
                })
                ->pluck('primary_key');
        } else {
            $results = $this->model->where('primary_key', 'like', $this->prefix.str_replace('*', '%', $word))
                ->where(function ($q) {
                    return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
                })
                ->pluck('primary_key');
        }

        return array_map(
            function ($item) use ($noPrefix) {
                if ($noPrefix && substr($item, 0, strlen($this->prefix)) == $this->prefix) {
                    return substr($item, strlen($this->prefix));
                }

                return $item;
            },
            $results->toArray() ?? []
        );
    }

    public function flatList(string $key, int $limit = -1): array
    {
        return array_slice(
            $this->model->where(['primary_key' => $this->prefix.$key, 'secondary_key' => null])
                ->where(function ($q) {
                    return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
                })
                ->value('list') ?? [], 0, $limit
        );
    }

    public function addToFlatList(string $key, $value): bool
    {
        $row = $this->model->firstOrNew(['primary_key' => $this->prefix.$key, 'secondary_key' => null]);

        if ($row->expired_at !== null && Carbon::now()->gt($row->expired_at)) {
            $row->list = (array) $value;
            $row->expired_at = null;
        } else {
            $row->list = array_merge($row->list ?? [], (array) $value);
        }

        $row->score = $row->score ?? 0;
        return (bool) $row->save();
    }

    public function valueList(string $key, int $limit = -1, bool $orderByAsc = false, bool $withValues = false): array
    {
        $rows = $this->model->where('primary_key', $this->prefix.$key)
            ->where(function ($q) {
                return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
            })
            ->whereNotNull('secondary_key')
            ->orderBy('score', $orderByAsc ? 'asc' : 'desc')
            ->when($limit > -1, function ($q) use ($limit) {
                return $q->limit($limit + 1);
            })->pluck('score', 'secondary_key') ?? Collection::make();

        return $withValues ? $rows->toArray() : array_keys($rows->toArray());
    }

    public function exists(string $key): bool
    {
        return $this->model->where(['primary_key' => $this->prefix.$key, 'secondary_key' => null])
            ->where(function ($q) {
                return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
            })
            ->exists();
    }

    public function timeLeft(string $key): int
    {
        $expired_at = $this->model->where(['primary_key' => $this->prefix.$key])->value('expired_at');

        if ($expired_at === null) {
            return -2;
        }

        $ttl = $expired_at->timestamp - Carbon::now()->timestamp;
        return $ttl <= 0 ? -1 : $ttl;
    }

    public function setExpiration(string $key, int $time): bool
    {
        try {
            return $this->model
                ->where(['primary_key' => $this->prefix.$key])
                ->where(function ($q) {
                    return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
                })
                ->update([
                    'expired_at' => Carbon::now()->addSeconds($time)
                ]);
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                $visits = $this->model
                    ->where(['primary_key' => $this->prefix.$key])
                    ->where(function ($q) {
                        return $q->where('expired_at', '>', Carbon::now())->orWhereNull('expired_at');
                    })
                    ->get();

                $visits->groupBy('secondary_key')->each(function ($item) use ($time) {
                    $totalScore = $item->sum('score');

                    $item->slice(1)->each(function ($item) {
                        $item->delete();
                    });

                    $item->first()->update([
                        'score' => $totalScore,
                        'expired_at' => Carbon::now()->addSeconds($time)
                    ]);
                });

                return true;
            }
        }
    }

    public function delete($key, $member = null): bool
    {
        if (is_array($key)) {
            array_walk($key, function ($item) {
                $this->delete($item);
            });
            return true;
        }

        if (!empty($member) || is_numeric($member)) {
            return $this->model->where(['primary_key' => $this->prefix.$key, 'secondary_key' => $member])->delete();
        } else {
            return $this->model->where(['primary_key' => $this->prefix.$key])->delete();
        }
    }
}
