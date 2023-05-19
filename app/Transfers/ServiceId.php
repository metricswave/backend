<?php

namespace App\Transfers;

enum ServiceId: int
{
    case Github = 1;
    case Google = 2;
    case Telegram = 3;
}
