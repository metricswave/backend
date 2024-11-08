<?php

use Illuminate\Support\Facades\Mail;
use MetricsWave\Users\Console\Commands\MailTeamsWithoutEventsAfterADayCommand;

use function Pest\Laravel\artisan;

it('send expected mail to non initiated teams', function () {
    Mail::fake();

    [$user, $team] = user_with_team(teamAttributes: ['initiated' => false]);
    user_with_team(teamAttributes: ['initiated' => true]);

    $this->travelTo(now()->addDay()->addHour());

    Artisan::registerCommand(new MailTeamsWithoutEventsAfterADayCommand);
    artisan('app:teams:mail-without-events');

    Mail::assertQueuedCount(1);
});
