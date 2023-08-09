<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FakeEcommerceFunnelCommand extends Command
{
    private const START_DATE = '2023-08-09';
    private const TRIGGER_UUID = '0e14250f-1d56-4389-8913-f652e8fc5a65';
    private const STEPS = [
        "Cart",
        "Information",
        "Shipping",
        "Payment",
        "Success",
    ];

    protected $signature = 'app:fake:ecommerce-funnel';
    protected $description = 'Fake ecommerce funnel.';

    public function handle(): void
    {
        $this->info('Fake ecommerce funnel.');

        $numberOfVisits = $this->getRandomNumberOfVisits();
        $visits = array_fill(0, $numberOfVisits, null);

        $this->withProgressBar($visits, function () {
            $lastStep = random_int(1, count(self::STEPS));
            for ($i = 1; $i <= $lastStep; $i++) {
                Http::acceptJson()
                    ->asJson()
                    ->post('https://metricswave.com/webhooks/'.self::TRIGGER_UUID, [
                        'step' => self::STEPS[$i - 1],
                        'user_id' => random_int(1, 100),
                    ]);
            }
        });
    }

    private function getRandomNumberOfVisits(): int
    {
        $daysSinceStart = (now()->diffInDays(self::START_DATE) + 1);
        $multiplier = (random_int(1, 100) / 100);

        return random_int((2 * $daysSinceStart) * $multiplier, (6 * $daysSinceStart) * $multiplier);
    }
}
