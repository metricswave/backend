<?php

namespace App\Services\Prices;

use App\Models\Price;
use App\Transfers\PriceType;

class GetLandingPricesService
{
    public function __invoke(): LandingPrices
    {
        return new LandingPrices(
            $this->getMonthlyPrices(),
            $this->getLifetimePrices(),
        );
    }

    private function getMonthlyPrices(): Price
    {
        return Price::query()
            ->where('type', PriceType::Monthly)
            ->where('remaining', '>', 0)
            ->orderBy('price')
            ->firstOrFail();
    }

    private function getLifetimePrices(): Price
    {
        return Price::query()
            ->where('type', PriceType::Lifetime)
            ->where('remaining', '>', 0)
            ->orderBy('price')
            ->firstOrFail();
    }
}
