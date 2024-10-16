<?php

namespace App\Transfers;

enum PlanId: int
{
    case FREE = 1;
    case BASIC = 2;
    case STARTER = 3;
    case BUSINESS = 4;
    case CORPORATE = 5;
    case ENTERPRISE = 6;

    public function name(): string
    {
        return match ($this) {
            self::FREE => 'Free',
            self::BASIC => 'Basic',
            self::STARTER => 'Starter',
            self::BUSINESS => 'Business',
            self::CORPORATE => 'Corporate',
            self::ENTERPRISE => 'Enterprise',
        };
    }
}
