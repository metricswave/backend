<?php

namespace App\Transfers;

enum TriggerTypeId: int
{
    case Webhook = 1;
    case OnTime = 2;
    case WeatherSummary = 3;
}
