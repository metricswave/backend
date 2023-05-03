<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Str;

class CacheKey
{
    public static function generate(Model $model, string $key): string
    {
        return $model->getTable().':'.$model->id.'--'.Str::of($key)->camel()->toString();
    }
}
