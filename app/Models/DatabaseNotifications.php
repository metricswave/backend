<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification as LaravelDatabaseNotifications;

class DatabaseNotifications extends LaravelDatabaseNotifications
{
    protected $connection = 'visits';

    public function getTable(): string
    {
        return 'notifications_'.now()->year;
    }
}
