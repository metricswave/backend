<?php

namespace MetricsWave\Metrics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MetricsKeys
{
    public string|bool $modelName = false;

    public ?string $id = null;

    public string $visits;

    public string $primary = 'id';

    public bool $instanceOfModel = false;

    public string $tag;

    public function __construct(Model|string $subject, ?string $tag)
    {
        $this->modelName = $this->pluralModelName($subject);
        $this->primary = (new $subject())->getKeyName();
        $this->tag = $tag;
        $this->visits = $this->visits();

        if ($subject instanceof Model) {
            $this->instanceOfModel = true;
            $this->modelName = $this->modelName($subject);
            $this->id = $subject->{$subject->getKeyName()};
        }
    }

    public function pluralModelName($subject): string
    {
        return strtolower(Str::plural(class_basename(is_string($subject) ? $subject : get_class($subject))));
    }

    public function visits(): string
    {
        return (app()->environment('testing') ? 'testing:' : '').$this->modelName."_{$this->tag}";
    }

    public function modelName($subject): string
    {
        return strtolower(Str::singular(class_basename(get_class($subject))));
    }

    public function visitsTotal(): string
    {
        return "{$this->visits}_total";
    }

    public function period(string $period, bool $total = false): string
    {
        if ($total) {
            $total = Str::of($this->visitsTotal())->replace('_'.$period, '');

            return $total."_$period";
        }

        return "{$this->visits}_{$period}";
    }
}
