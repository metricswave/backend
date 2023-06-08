<?php

namespace App\Models;

use App\Events\TriggerCreated;
use App\Services\Visits\Visits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use function Emoji\is_single_emoji;

/**
 * @property array{version: string, fields: array{name: string, value: string|array|int}} $configuration
 * @property array{id: string, label: string, checked: bool, type: string} $via
 */
class Trigger extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'trigger_type_id',
        'uuid',
        'emoji',
        'title',
        'content',
        'configuration',
        'via',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'trigger_type_id' => 'integer',
        'configuration' => 'json',
        'via' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => TriggerCreated::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function triggerType(): BelongsTo
    {
        return $this->belongsTo(TriggerType::class);
    }

    public function visits($tag = 'visits'): Visits
    {
        return visitsService($this, $tag);
    }

    public function formattedContent(array $params): string
    {
        return $this->replaceVariables($this->content, $params);
    }

    private function replaceVariables(string $content, array $params): string
    {
        foreach ($params as $key => $value) {
            if ($value === null || is_array($value)) {
                continue;
            }

            $content = Str::replace('{'.$key.'}', $value, $content);
        }

        return $content;
    }

    public function formattedEmoji(array $params): string
    {
        if (is_single_emoji($params['emoji'] ?? null)) {
            return $params['emoji'];
        }

        return $this->emoji;
    }

    public function formattedTitle(array $params): string
    {
        return $this->replaceVariables($this->title, $params);
    }
}
