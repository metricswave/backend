<?php

namespace App\Repositories;

use App\Models\Trigger;
use App\Models\User;
use App\Transfers\Time;
use App\Transfers\Weekday;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TriggerRepository
{
    public function onTimeFor(Time $time, Weekday $weekday): Collection
    {
        return $this->builder()
            ->where('trigger_type_id', 1)
            ->where('time', $time->toString())
            ->where('weekdays', 'like', '%'.$weekday->toString().'%')
            ->get();
    }

    private function builder(): Builder|User
    {
        return Trigger::query();
    }
}
