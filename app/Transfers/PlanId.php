<?php

namespace App\Transfers;

enum PlanId: int
{
    case FREE = 1;
    case BASIC = 2;
    case BUSINESS = 3;
    case ENTERPRISE = 4;
}
