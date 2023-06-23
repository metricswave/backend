<?php

namespace App\Services\Prices;

use App\Models\Price;
use App\Transfers\PriceType;
use Illuminate\Support\Collection;

class GetLandingPricesService
{
    public function __invoke(): LandingPrices
    {
        return new LandingPrices([
            ... $this->unavailableLifetimePrice()->all(),
            ... $this->getLifetimePrices()->all(),
        ]);
    }

    private function unavailableLifetimePrice(): Collection
    {
        return Price::query()
            ->where('type', PriceType::Lifetime)
            ->where('remaining', 0)
            ->orderByDesc('price')
            ->take(1)
            ->get();
    }

    private function getLifetimePrices(): Collection
    {
        return Price::query()
            ->where('type', PriceType::Lifetime)
            ->where('remaining', '>', 0)
            ->orderBy('price')
            ->take(2)
            ->get();
    }

    private function getMonthlyPrices(): Price
    {
        return Price::query()
            ->where('type', PriceType::Monthly)
            ->where('remaining', '>', 0)
            ->orderBy('price')
            ->firstOrFail();
    }
}
