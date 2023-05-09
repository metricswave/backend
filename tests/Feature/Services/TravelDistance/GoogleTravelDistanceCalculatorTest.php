<?php

use App\Services\TravelDistance\Address;
use App\Services\TravelDistance\ArrivalTime;
use App\Services\TravelDistance\TravelDistanceCalculator;
use App\Services\TravelDistance\TravelMode;

$fakeGoogleDistanceMatrixApiCall = function (ArrivalTime $arrivalTime) {
    Http::fake([
        'https://maps.googleapis.com/maps/api/distancematrix/json?destinations=Via%20Roma%2C%201%2C%2010090%20San%20Gillio%20TO&origins=Via%20Roma%2C%201%2C%2010090%20San%20Gillio%20TO&mode=driving&arrival_time='.$arrivalTime->timestamp().'&units=metric&key=AIzaSyBgRSFSKd1j9LccC00R4Xr9K3PBbFzxhZA' => Http::response([
            'rows' => [
                [
                    'elements' => [
                        [
                            'distance' => [
                                'text' => '1 m',
                                'value' => 0,
                            ],
                            'duration' => [
                                'text' => '1 min',
                                'value' => 0,
                            ]
                        ]
                    ]
                ],
            ]
        ]),
    ]);
};

it('return expected travel distance', function () use ($fakeGoogleDistanceMatrixApiCall) {
    $origin = new Address('Via Roma, 1, 10090 San Gillio TO');
    $destination = new Address('Via Roma, 1, 10090 San Gillio TO');
    $travelMode = TravelMode::DRIVING;
    $arrivalTime = ArrivalTime::now();

    $fakeGoogleDistanceMatrixApiCall($arrivalTime);

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
