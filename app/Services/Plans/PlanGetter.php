<?php

namespace App\Services\Plans;

use App\Transfers\Plan;
use App\Transfers\PlanId;
use Illuminate\Support\Collection;

class PlanGetter
{
    public function get(PlanId $id): Plan
    {
        return $this->all()->first(fn(Plan $plan) => $plan->id === $id);
    }

    public function all(): Collection
    {
        return collect([
            new Plan(PlanId::FREE, 500),
            new Plan(PlanId::BASIC, 10000),
        ]);
    }
}
