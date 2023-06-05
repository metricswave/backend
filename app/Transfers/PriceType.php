<?php

namespace App\Transfers;

enum PriceType: string
{
    case Monthly = 'monthly';
    case Lifetime = 'lifetime';
}
