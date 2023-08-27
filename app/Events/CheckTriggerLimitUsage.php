<?php

namespace App\Events;

use App\Notifications\TriggerNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckTriggerLimitUsage
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public readonly TriggerNotification $notification)
    {
    }
}
