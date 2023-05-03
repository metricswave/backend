<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Statamic\Facades\Entry;

class GenerateSitemapCommand extends Command
{
    private const SITEMAP_PATH = 'public/sitemap.xml';

    protected $signature = 'app:generate-sitemap';

    protected $description = 'Generate sitemap.xml';

    public function handle(): int
    {
        $sitemap = Sitemap::create()
            ->add($this->url('', 1))
            ->add($this->url('/trigger/deployments-notification', 0.8))
            ->add($this->url('/trigger/terminal', 0.8))
            ->add($this->url('/trigger/medication-reminder', 0.8))
            ->add($this->url('/roadmap', 0.8))
            ->add($this->url('/blog', 0.8, Url::CHANGE_FREQUENCY_DAILY))
            ->add($this->url('/open', 0.8))
            ->add($this->url('/documentation', 0.7))
            ->add($this->url('/terms-and-conditions', 0.1))
            ->add($this->url('/privacy-policy', 0.1));

        $pages = Entry::query()->where('date', '<=', now())->get();
        foreach ($pages as $page) {
            $sitemap->add(Url::create($page->absoluteUrl())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.8)
            );
        }

        $sitemap->writeToFile(self::SITEMAP_PATH);

        return self::SUCCESS;
    }

    private function url(string $path, float $priority, string $frequency = Url::CHANGE_FREQUENCY_YEARLY): Url
    {
        return Url::create(url($path))
            ->setChangeFrequency($frequency)
            ->setPriority($priority);
    }
}
