<?php

namespace App\Transfers\Dashboard;

enum DashboardItemType: string
{
    case stats = 'stats';
    case parameter = 'parameter';
    case funnel = 'funnel';
    case number = 'number';
}
