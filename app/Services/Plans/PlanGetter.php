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
            new Plan(PlanId::FREE, 'Free', 0, false, 6, 1000, false),
            new Plan(PlanId::BASIC, 'Basic', 900, true, 6, 25000, false),
            new Plan(PlanId::BUSINESS, 'Business', 4900, true, null, 75000, false),
            new Plan(PlanId::ENTERPRISE, 'Enterprise', null, false, null, null, true),
        ]);
    }
}
