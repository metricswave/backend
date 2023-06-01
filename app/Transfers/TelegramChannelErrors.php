<?php

namespace App\Transfers;

enum TelegramChannelErrors: string
{
    case GROUP_CHAT_UPGRADED_TO_SUPERGROUP_CHAT = 'GROUP_CHAT_UPGRADED_TO_SUPERGROUP_CHAT';
}
