<?php

use App\Jobs\QueueOnTimeTriggerNotifications;

it('enqueues a job to queue on time trigger notifications', function () {
    Queue::fake();
    $this->artisan('app:trigger:on-time');

    Queue::assertPushed(QueueOnTimeTriggerNotifications::class, function (QueueOnTimeTriggerNotifications $job) {
        return get_private_property($job, 'time')->toString() === Date::now()->format('H:i')
            && get_private_property($job, 'weekday')->dayOfWeek === Date::now()->dayOfWeek;
    });
});
