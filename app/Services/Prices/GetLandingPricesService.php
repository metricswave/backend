<?php

namespace App\Services\Prices;

use App\Models\Price;
use Illuminate\Support\Collection;

class GetLandingPricesService
{
    /**
     * @return Collection<Price>
     */
    public function __invoke(): Collection
    {
        $prices = Price::query()->orderBy('price')->get();
        $grouped = $prices->groupBy(fn(Price $price) => $price->remaining === 0 ? 'sold' : 'available');

        if ($prices->count() === 0) {
            return collect();
        }

        if (isset($grouped['sold'])) {
            return collect([
                $grouped['sold']->last(),
                ...$grouped['available']->slice(0, 2)->all(),
            ]);
        }

        return $grouped['available']->slice(0, 3);
    }
}
