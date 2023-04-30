<?php

namespace App\Services\Triggers;

use Exception;
use Illuminate\Support\Collection;

class MissingTriggerParams extends Exception
{
    public static function with(Collection $missingParams): self
    {
        return new static('Missing parameters: '.$missingParams->implode(', '));
    }
}
