<?php

namespace App\Jobs;

use App\Notifications\TriggerNotification;
use App\Repositories\TriggerRepository;
use App\Services\Weather\Location;
use App\Services\Weather\WeatherForecastGetter;
use App\Transfers\Time;
use App\Transfers\Weekday;
use Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * @method static void dispatch(Time $time, Weekday $weekday)
 */
class QueueWeatherSummaryTriggerNotificationsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Time $time,
        private readonly Weekday $weekday
    ) {
    }

    public function handle(WeatherForecastGetter $forecastGetter, TriggerRepository $repository): void
    {
        $triggers = $repository->weatherSummaryFor($this->time, $this->weekday);

        foreach ($triggers as $trigger) {
            $location = Location::fromLocationField($trigger->configuration['fields']['location']);
            $forecasts = $forecastGetter->daily($location);

            $trigger->user->notify(new TriggerNotification(
                $trigger,
                Arr::dot([
                    'time' => $this->time->toString(),
                    'weekday' => $this->weekday->toString(),
                    'weather' => $forecasts->toArray(),
                ])
            ));
        }
    }
}
