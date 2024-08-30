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
            ->add($this->url('/es', 1))
            ->add($this->url('/blog', 0.8, Url::CHANGE_FREQUENCY_DAILY))
            ->add($this->url('/blog/category/changelog', 0.8, Url::CHANGE_FREQUENCY_DAILY))
            ->add($this->url('/open', 0.8))
            ->add($this->url('/documentation', 0.7))
            ->add($this->url('/terms-and-conditions', 0.1))
            ->add($this->url('/privacy-policy', 0.1));

        $pages = Entry::query()->where('date', '<=', now())->where('published', true)->get();
        foreach ($pages as $page) {
            $sitemap->add(Url::create($this->getUrl($page))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority($page->collection()->handle() === 'pages' ? 0.8 : 0.7)
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

    private function getUrl(mixed $page): mixed
    {
        if ($page->collection()->handle() !== 'pages') {
            return $page->absoluteUrl();
        }

        if ((string) $page->article_locale !== 'en') {
            return ((string) $page->article_locale).$page->url();
        }

        return $page->absoluteUrl();
    }
}
