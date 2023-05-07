<?php

namespace App\Services\TravelDistance;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;

class GoogleTravelDistanceCalculator implements TravelDistanceCalculator
{
    public function calculate(
        Address $origin,
        Address $destination,
        TravelMode $travelMode,
        ArrivalTime $arrivalTime = null
    ): TravelDistance {
        $arrivalTime ??= ArrivalTime::now();

        $data = $this->getRawData($origin, $destination, $travelMode, $arrivalTime);

        return new TravelDistance(
            $origin,
            $destination,
            $travelMode,
            $arrivalTime,
            new Distance(
                $data['rows'][0]['elements'][0]['distance']['text'],
                $data['rows'][0]['elements'][0]['distance']['value'],
            ),
            new Duration(
                $data['rows'][0]['elements'][0]['duration']['text'],
                $data['rows'][0]['elements'][0]['duration']['value'],
            ),
        );
    }

    /**
     * @return array{
     *     destination_addresses: string[],
     *     origin_addresses: string[],
     *     rows: array{
     *          elements: array{
     *              distance: array{
     *                  text: string,
     *                  value: int,
     *              },
     *              duration: array{
     *                  text: string,
     *                  value: int,
     *              },
     *              status: string,
     *          }[],
     *     },
     *     status: string,
     * }
     */
    private function getRawData(
        Address $origin,
        Address $destination,
        TravelMode $travelMode,
        ArrivalTime $arrivalTime
    ): array {
        return Cache::remember(
            $this->cacheKeyFor($origin, $destination, $travelMode, $arrivalTime),
            Date::now()->addHour(),
            fn() => Http::get(
                'https://maps.googleapis.com/maps/api/distancematrix/json',
                [
                    'destinations' => $destination->address,
                    'origins' => $origin->address,
                    'mode' => $travelMode->value,
                    'arrival_time' => $arrivalTime->timestamp(),
                    'units' => 'metric',
                    'key' => config('services.google_maps.key'),
                ]
            )->json()
        );
    }

    private function cacheKeyFor(
        Address $origin,
        Address $destination,
        TravelMode $travelMode,
        ArrivalTime $arrivalTime
    ): string {
        return 'weather-forecast-'
            .$origin->address
            .'-'
            .$destination->address
            .'-'
            .$travelMode->value
            .'-'.($arrivalTime->timestamp());
    }
}
