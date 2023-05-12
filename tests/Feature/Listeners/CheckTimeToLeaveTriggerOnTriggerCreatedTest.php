<?php

use App\Events\TriggerCreated;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Services\Triggers\TimeToLeaveTriggersProcessor;
use App\Transfers\TriggerTypeId;

it('should process time to leave trigger', function () {
    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create(['id' => TriggerTypeId::TimeToLeave->value]))
        ->createQuietly();

    $this->mock(TimeToLeaveTriggersProcessor::class)
        ->shouldReceive('__invoke')
        ->withArgs(fn($args) => $args->id === $trigger->id)
        ->once();

    event(new TriggerCreated($trigger));
});
