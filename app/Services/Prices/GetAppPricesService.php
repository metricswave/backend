<?php

namespace App\Services\Prices;

use App\Models\Price;
use App\Transfers\PriceType;
use Illuminate\Support\Collection;

class GetAppPricesService
{
    public function __invoke(): LandingPrices
    {
        return new LandingPrices([
            ...$this->unavailableMonthlyPrice()->all(),
            ...$this->getMonthlyPrices()->all(),
        ]);
    }

    private function unavailableMonthlyPrice(): Collection
    {
        return Price::query()
            ->where('type', PriceType::Monthly)
            ->where('remaining', 0)
            ->orderByDesc('price')
            ->take(1)
            ->get();
    }

    private function getMonthlyPrices(): Collection
    {
        return Price::query()
            ->where('type', PriceType::Monthly)
            ->where('remaining', '>', 0)
            ->orderBy('price')
            ->take(2)
            ->get();
    }
}
