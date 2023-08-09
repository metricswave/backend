<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FakeEcommerceVisitsCommand extends Command
{
    private const START_DATE = '2023-08-09';
    private const TRIGGER_UUID = '30a512e6-01b2-4430-bc04-41b4af5371e9';

    protected $signature = 'app:fake:ecommerce-visits {--dry-run}';
    protected $description = 'Fake ecommerce visits.';

    public function handle(): void
    {
        $this->info('Fake ecommerce visits.');

        $numberOfVisits = $this->getRandomNumberOfVisits();
        $visits = array_fill(0, $numberOfVisits, null);

        $this->withProgressBar($visits, function () {
            $params = [
                'deviceName' => $this->fakeDeviceName(),
                'path' => $this->fakePath(),
                'domain' => 'proteinshakes.shop',
                'language' => $this->fakeLanguage(),
                'userAgent' => $this->fakeUserAgent(),
                'platform' => $this->fakePlatform(),
                'visit' => random_int(1, 10) > 4 ? "1" : "0",
                ...$this->fakeUtmParams(),
            ];

            if ($this->option('dry-run')) {
                $this->info('Dry run: '.json_encode($params));
                return;
            }

            Http::acceptJson()
                ->asJson()
                ->post('https://metricswave.com/webhooks/'.self::TRIGGER_UUID, $params);
        });
    }

    private function getRandomNumberOfVisits(): int
    {
        $daysSinceStart = (now()->diffInDays(self::START_DATE) + 1);
        $multiplier = (random_int(1, 100) / 100);

        return random_int((5 * $daysSinceStart) * $multiplier, (20 * $daysSinceStart) * $multiplier);
    }

    private function fakeDeviceName(): string
    {
        $deviceNames = [
            'e1610285-f627-4fc8-a4c8-47d06f191ccb' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccc' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccd' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191cce' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccf' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccg' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191cch' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191cci' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccj' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191cck' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccl' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccm' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccn' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191cco' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccp' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccq' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccr' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccs' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191cct' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccu' => 1,
            'e1610285-f627-4fc8-a4c8-47d06f191ccv' => 1,
            'new' => 30,
        ];

        $deviceName = $this->randomItemFromWeightedArray($deviceNames);

        return $deviceName === "new" ? Str::uuid()->toString() : $deviceName;
    }

    private function randomItemFromWeightedArray(array $items): string
    {
        $weights = array_values($items); // Extract weights
        $items = array_keys($items); // Extract items

        $weightSum = array_sum($weights);
        $cumulativeWeights = array();
        $cumulativeWeight = 0;

        foreach ($weights as $weight) {
            $cumulativeWeight += $weight / $weightSum;
            $cumulativeWeights[] = $cumulativeWeight;
        }

        $rand = mt_rand() / mt_getrandmax();

        foreach ($cumulativeWeights as $key => $weight) {
            if ($rand < $weight) {
                return $items[$key];
            }
        }

        return $items[0];
    }

    private function fakePath(): string
    {
        $paths = [
            '/' => 100,
            '/cart' => 50,
            '/checkout/information' => 49,
            '/checkout/shipping' => 48,
            '/checkout/payment' => 47,
            '/checkout/success' => 46,
            '/checkout/failed' => 20,
            '/category/top-sellers' => 30,
            '/category/protein' => 20,
            '/category/pre-workout' => 20,
            '/category/intra-workout' => 20,
            '/category/post-workout' => 20,
            '/category/weight-gainer' => 20,
            '/category/fuel' => 20,
            '/category/recovery' => 20,
            '/category/health' => 20,
            '/category/food' => 20,
            '/category/accessories' => 20,
            '/category/endurance' => 20,
            '/category/muscle-building' => 20,
            '/category/weight-loss' => 20,
            '/page/2' => 10,
            '/page/3' => 9,
            '/page/4' => 8,
            '/page/5' => 7,
            '/page/6' => 6,
            '/page/7' => 5,
            '/page/8' => 4,
            '/page/9' => 3,
            '/page/10' => 3,
            '/page/11' => 3,
            '/page/12' => 2,
            '/page/13' => 2,
            '/page/14' => 2,
            '/page/15' => 2,
            '/page/16' => 1,
            '/page/17' => 1,
        ];

        return $this->randomItemFromWeightedArray($paths);
    }

    private function fakeLanguage(): string
    {
        $languages = [
            'en-US' => 100,
            'en-GB' => 75,
            'de-DE' => 50,
            'fr-FR' => 50,
            'es-ES' => 50,
        ];

        return $this->randomItemFromWeightedArray($languages);
    }

    private function fakeUserAgent(): string
    {
        $userAgents = [
            'Chrome' => 100,
            'Firefox' => 75,
            'Safari' => 50,
            'Edge' => 50,
            'Opera' => 50,
            'Internet Explorer' => 50,
        ];

        return $this->randomItemFromWeightedArray($userAgents);
    }

    private function fakePlatform(): string
    {
        $platforms = [
            'Windows' => 50,
            'Macintosh' => 50,
            'Linux' => 10,
            'Android' => 50,
            'iOS' => 50,
        ];

        return $this->randomItemFromWeightedArray($platforms);
    }

    private function fakeUtmParams(): array
    {
        $utmSources = [
            'facebook' => 50,
            'instagram' => 50,
            'twitter' => 50,
            'youtube' => 50,
            'google' => 50,
            'bing' => 50,
            'yahoo' => 50,
            'email' => 50,
            'newsletter' => 50,
            'affiliate' => 50,
            'cpc' => 50,
            'display' => 50,
            'direct' => 50,
        ];

        $utmSources = $this->randomItemFromWeightedArray($utmSources);
        if ($utmSources === 'direct') {
            $utmSources = null;
        }

        if ($utmSources === 'email' || $utmSources === 'newsletter') {
            $referrer = array_random(['mail.google.com', 'hotmail.com', 'outlook.com']);
        } elseif ($utmSources === 'affiliate') {
            $referrer = array_random(['clickbank.com', 'jvzoo.com', 'warriorplus.com']);
        } elseif ($utmSources === 'cpc' || $utmSources === 'display') {
            $referrer = array_random(['google.com', 'bing.com', 'yahoo.com']);
        } elseif ($utmSources !== null) {
            $referrer = $utmSources.'.com';
        } else {
            $referrer = null;
        }

        return [
            'referrer' => $referrer,
            'utm_source' => $utmSources,
            'utm_medium' => $utmSources === 'direct' ? null : array_random([
                'cpc', 'display', 'email', 'newsletter', 'affiliate'
            ]),
            'utm_campaign' => $utmSources === 'direct' ? null : Str::random(10),
            'utm_term' => $utmSources === 'direct' ? null : Str::random(10),
            'utm_content' => $utmSources === 'direct' ? null : Str::random(10),
        ];
    }
}
