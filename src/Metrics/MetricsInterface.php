<?php

namespace MetricsWave\Metrics;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

interface MetricsInterface
{
    public function __construct(Model $subject, string $tag);

    public function count();

    public function countAll(Carbon $from = null, Carbon $to = null): Collection;

    public function countAllByParam(string $param, Carbon $date): Collection;

    public function countAllByParamAndDate(string $param, Carbon $from, Carbon $to): Collection;

    public function increment($inc = 1, CarbonInterface $date = null): void;

    public function period(string $period): static;

    public function recordParams(array $params, int $inc = 1, CarbonInterface $date = null, bool $totalOnly = false): void;

    public function delete(): void;

    public function deleteParams(array $params): void;
}
