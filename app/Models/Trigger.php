<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property int $trigger_type_id
 * @property string $uuid
 * @property string $emoji
 * @property string $title
 * @property string $content
 * @property array{version: string, fields: array{name: string, value: string|array|int}} $configuration
 */
class Trigger extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trigger_type_id',
        'uuid',
        'emoji',
        'title',
        'content',
        'configuration',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'trigger_type_id' => 'integer',
        'configuration' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function triggerType(): BelongsTo
    {
        return $this->belongsTo(TriggerType::class);
    }

    public function formattedContent(array $params): string
    {
        return $this->replaceVariables($this->content, $params);
    }

    private function replaceVariables(string $content, array $params): string
    {
        foreach ($params as $key => $value) {
            $content = Str::replace('{'.$key.'}', $value, $content);
        }

        return $content;
    }

    public function formattedTitle(array $params): string
    {
        return $this->replaceVariables($this->title, $params);
    }
}
