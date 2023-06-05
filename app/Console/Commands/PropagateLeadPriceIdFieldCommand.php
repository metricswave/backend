<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Models\Price;
use Illuminate\Console\Command;

class PropagateLeadPriceIdFieldCommand extends Command
{
    protected $signature = 'app:leads:propagate-price-id';
    protected $description = 'Propagate lead price_id field';

    public function handle(): int
    {
        $this->info('Propagating lead price_id field...');

        $leadsMissingPriceId = Lead::query()
            ->where('price_id', null)
            ->whereNotNull('paid_at')
            ->get();
        $prices = Price::all();

        $this->withProgressBar($leadsMissingPriceId, function (Lead $lead) use ($prices) {
            $price = $prices->first(fn(Price $price) => $price->price === $lead->paid_price);
            $lead->update(['price_id' => $price->id]);
        });

        $this->newLine(2);
        $this->info('Done!');

        return self::SUCCESS;
    }
}
