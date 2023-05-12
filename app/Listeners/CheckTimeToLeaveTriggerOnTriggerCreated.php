<?php

namespace App\Listeners;

use App\Events\TriggerCreated;
use App\Services\Triggers\TimeToLeaveTriggersProcessor;
use App\Transfers\TriggerTypeId;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckTimeToLeaveTriggerOnTriggerCreated implements ShouldQueue
{
    public function __construct(private readonly TimeToLeaveTriggersProcessor $processor)
    {
    }

    public function handle(TriggerCreated $event): void
    {
        if ($event->trigger->trigger_type_id !== TriggerTypeId::TimeToLeave->value) {
            return;
        }

        ($this->processor)($event->trigger);
    }
}
