<?php

use App\Services\TravelDistance\Address;
use App\Services\TravelDistance\ArrivalTime;
use App\Services\TravelDistance\TravelDistanceCalculator;
use App\Services\TravelDistance\TravelMode;

it('return expected travel distance', function () {
    $origin = new Address('Via Roma, 1, 10090 San Gillio TO');
    $destination = new Address('Via Roma, 1, 10090 San Gillio TO');
    $travelMode = TravelMode::DRIVING;
    $arrivalTime = ArrivalTime::now();

    $travelDistance = $this->app->make(TravelDistanceCalculator::class)
        ->calculate($origin, $destination, $travelMode, $arrivalTime);

    expect($travelDistance)
        ->origin->toBe($origin)
        ->destination->toBe($destination)
        ->travelMode->toBe($travelMode)
        ->arrivalTime->toBe($arrivalTime)
        ->distance->distance->toBe('1 m')
        ->distance->meters->toBe(0)
        ->duration->duration->toBe('1 min')
        ->duration->seconds->toBe(0);
});
