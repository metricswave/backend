<?php

namespace App\Services\Visits;

use Awssat\Visits\Keys;
use Awssat\Visits\Visits as AwssatVisits;
use Illuminate\Support\Collection;

class Visits extends AwssatVisits
{
    private string $period;

    public function __construct($subject = null, $tag = 'visits')
    {
        $this->config = config('visits');

        $this->connection = $this->determineConnection($this->config['engine'] ?? 'redis')
            ->connect($this->config['connection'])
            ->setPrefix($this->config['keys_prefix'] ?? $this->config['redis_keys_prefix'] ?? 'visits');

        if (!$this->connection) {
            return;
        }

        $this->periods = $this->config['periods'];
        $this->ipSeconds = $this->config['remember_ip'];
        $this->fresh = $this->config['always_fresh'];
        $this->ignoreCrawlers = $this->config['ignore_crawlers'];
        $this->globalIgnore = $this->config['global_ignore'];
        $this->subject = $subject;
        $this->keys = new Keys($subject, preg_replace('/[^a-z0-9_]/i', '', $tag));

        // if (! empty($this->keys->id)) {
        //     $this->periodsSync();
        // }
    }

    public function period($period): Visits|static
    {
        if (in_array($period, $this->periods)) {
            $this->keys->visits = $this->keys->period($period);
            $this->period = $period;
        } else {
            throw new InvalidPeriod($period);
        }

        return $this;
    }

    public function increment($inc = 1, $force = true, $ignore = []): bool
    {
        $response = parent::increment($inc, $force, $ignore);
        $this->periodsSync();

        return $response;
    }

    public function countAll(): Collection
    {
        $key = $this->keys->visits;
        $id = $this->keys->id;

        return $this->connection->all($this->period, $key, $id);
    }
}
