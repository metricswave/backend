<?php

namespace App\Services\TravelDistance;

interface TravelDistanceCalculator
{
    public function calculate(
        Address $origin,
        Address $destination,
        TravelMode $travelMode,
        ArrivalTime $arrivalTime = null
    ): TravelDistance;
}
