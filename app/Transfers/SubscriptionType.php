<?php

namespace App\Transfers;

enum SubscriptionType: string
{
    case Free = 'free';
    case Lifetime = 'lifetime';
    case Monthly = 'monthly';
    case Yearly = 'yearly';
}
