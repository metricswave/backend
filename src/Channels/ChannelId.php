<?php

namespace MetricsWave\Channels;

enum ChannelId: int
{
    case Telegram = 1;
    case Stripe = 2;
}
