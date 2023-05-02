<?php

namespace App\Services\Weather;

class Location
{
    public function __construct(
        public readonly string $city,
        public readonly string $country,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }

    public static function fromLocationField(array $location): self
    {
        return new self(
            $location['city'],
            $location['country'],
            $location['latitude'],
            $location['longitude'],
        );
    }
}
