<?php

use Illuminate\Support\Facades\Artisan;
use MetricsWave\Metrics\Console\Commands\CreateVisitsTableCommand;
use MetricsWave\Metrics\Console\Commands\GetStripeChargesFromTeamServicesCommand;
use MetricsWave\Teams\Console\Commands\DeleteVisitsByTeamIdCommand;
use MetricsWave\Teams\Console\Commands\DeleteVisitsByTriggerCommand;
use MetricsWave\Teams\Console\Commands\MigrateModelsToTeamsCommand;
use MetricsWave\Users\Console\Commands\CreateNotificationsTableCommand;
use MetricsWave\Users\Console\Commands\MailArticleToUsersCommand;
use MetricsWave\Users\Console\Commands\MailTeamsWithoutEventsAfterADayCommand;
use MetricsWave\Users\Console\Commands\UserCalendarsGetterCommand;
use MetricsWave\Users\Console\Commands\UserLifetimeLicenceMailCommand;
use MetricsWave\Users\Console\Commands\UserRoadmapMailCommand;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Teams
Artisan::registerCommand(new MigrateModelsToTeamsCommand);
Artisan::registerCommand(new DeleteVisitsByTeamIdCommand);

// Triggers
Artisan::registerCommand(new DeleteVisitsByTriggerCommand);

// Metrics
Artisan::registerCommand(new CreateVisitsTableCommand);
Artisan::registerCommand(new GetStripeChargesFromTeamServicesCommand);

// Users
Artisan::registerCommand(new MailArticleToUsersCommand);
Artisan::registerCommand(new MailTeamsWithoutEventsAfterADayCommand);
Artisan::registerCommand(new UserCalendarsGetterCommand);
Artisan::registerCommand(new UserLifetimeLicenceMailCommand);
Artisan::registerCommand(new UserRoadmapMailCommand);
Artisan::registerCommand(new CreateNotificationsTableCommand);
