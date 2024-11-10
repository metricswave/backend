<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property array{version: string, fields: array} $configuration
 * @mixin IdeHelperTriggerType
 */
class TriggerType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'configuration',
    ];

    protected $casts = [
        'configuration' => 'json',
    ];
}
