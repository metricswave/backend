<?php

namespace App\Console\Commands;

use App\Jobs\Calendar\UserServiceCalendarGetterJob;
use App\Models\User;
use App\Models\UserService;
use App\Repositories\UserServiceRepository;
use App\Transfers\ServiceId;
use Illuminate\Console\Command;

class UserCalendarsGetterCommand extends Command
{
    protected $signature = 'app:user:get-calendars {--user=}';
    protected $description = 'Get calendars for all users with Google service connected';

    public function handle(UserServiceRepository $repository): int
    {
        $this->info('Getting calendars for all users with Google service connected...');

        if ($this->option('user')) {
            $userServices = $repository->byServiceIdAndUser(
                ServiceId::Google,
                User::where('email', $this->option('user'))->first(),
            );
        } else {
            $userServices = $repository->byServiceId(ServiceId::Google);
        }

        $this->withProgressBar($userServices, function (UserService $userService): void {
            if ($this->option('user')) {
                UserServiceCalendarGetterJob::dispatchSync($userService);
            } else {
                UserServiceCalendarGetterJob::dispatch($userService);
            }
        });

        return self::SUCCESS;
    }
}
