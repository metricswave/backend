<?php

use App\Jobs\QueueOnTimeTriggerNotificationsJob;

it('enqueues a job to queue on time trigger notifications', function () {
    Queue::fake();
    $this->artisan('app:trigger:on-time');

    Queue::assertPushed(QueueOnTimeTriggerNotificationsJob::class, function (QueueOnTimeTriggerNotificationsJob $job) {
        return get_private_property($job, 'time')->toString() === Date::now()->format('H:i')
            && get_private_property($job, 'weekday')->dayOfWeek === Date::now()->dayOfWeek;
    });
});
