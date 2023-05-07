<?php

namespace App\Services\TravelDistance;

enum TravelMode: string
{
    case DRIVING = 'driving';
    case WALKING = 'walking';
    case BICYCLING = 'bicycling';
    case TRANSIT = 'transit';
}
