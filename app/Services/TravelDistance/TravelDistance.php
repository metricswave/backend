<?php

namespace App\Services\TravelDistance;

class TravelDistance
{
    public function __construct(
        public readonly Address $origin,
        public readonly Address $destination,
        public readonly TravelMode $travelMode,
        public readonly ArrivalTime $arrivalTime,
        public readonly Distance $distance,
        public readonly Duration $duration,
    ) {
    }
}
