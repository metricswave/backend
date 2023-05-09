<?php

namespace App\Repositories;

use App\Models\Trigger;
use App\Models\User;
use App\Transfers\Time;
use App\Transfers\TriggerTypeId;
use App\Transfers\Weekday;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TriggerRepository
{
    /**
     * @param  Time  $time
     * @param  Weekday  $weekday
     * @return Collection<Trigger>
     */
    public function timeToLeaveFor(Time $time, Weekday $weekday): Collection
    {
        return $this->builder()
            ->where('trigger_type_id', TriggerTypeId::TimeToLeave)
            ->where('arrival_time', $time->toString())
            ->where('weekdays', 'like', '%'.$weekday->toString().'%')
            ->get();
    }

    private function builder(): Builder|User
    {
        return Trigger::query();
    }

    /**
     * @param  Time  $time
     * @param  Weekday  $weekday
     * @return Collection<Trigger>
     */
    public function onTimeFor(Time $time, Weekday $weekday): Collection
    {
        return $this->byType(TriggerTypeId::OnTime, $time, $weekday);
    }

    private function byType(TriggerTypeId $type, Time $time, Weekday $weekday): Collection
    {
        return $this->builder()
            ->where('trigger_type_id', $type)
            ->where('time', $time->toString())
            ->where('weekdays', 'like', '%'.$weekday->toString().'%')
            ->get();
    }

    /**
     * @param  Time  $time
     * @param  Weekday  $weekday
     * @return Collection<Trigger>
     */
    public function weatherSummaryFor(Time $time, Weekday $weekday): Collection
    {
        return $this->byType(TriggerTypeId::WeatherSummary, $time, $weekday);
    }
}
