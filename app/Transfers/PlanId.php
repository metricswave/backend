<?php

namespace App\Transfers;

enum PlanId: int
{
    case FREE = 1;
    case BASIC = 2;
    case STARTER = 3;
    case BUSINESS = 4;
    case ENTERPRISE = 5;
}
