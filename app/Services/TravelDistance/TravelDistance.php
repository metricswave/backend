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

    public function toArray(): array
    {
        return [
            'origin' => $this->origin->address,
            'destination' => $this->destination->address,
            'travel_mode' => $this->travelMode->value,
            'arrival_time' => $this->arrivalTime->timeFormatted(),
            'distance' => $this->distance->distance,
            'meters' => $this->distance->meters,
            'duration' => $this->duration->duration,
            'seconds' => $this->duration->seconds,
        ];
    }
}
