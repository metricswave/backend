<?php

namespace MetricsWave\Metrics\Infrastructure;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

interface MetricsConnection
{
    public function get(string $key, int $member = null): int;

    public function all(
        string $period,
        string $key,
        $member = null,
        Carbon $from = null,
        Carbon $to = null
    ): Collection;

    public function allByParam(string $key, Carbon $date): Collection;

    public function increment(string $key, int $value, int $member = null): void;

    public function incrementWithExpiration(string $key, mixed $inc, mixed $id, int $expireInSeconds): void;
}
