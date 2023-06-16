<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Str;

class CacheKey
{
    public static function generateForModel(Model $model, array|string $key): string
    {
        return self::generate($model->getTable(), $model->id, $key);
    }

    public static function generate(string $type, string $id, array|string $params = []): string
    {
        if (is_array($params)) {
            $params = implode('_', $params);
        }

        return $type.'::'.$id.'::'.Str::of($params)->snake()->toString();
    }
}
