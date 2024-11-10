<?php

namespace App\Models;

use App\Events\TriggerCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use MetricsWave\Metrics\MetricsInterface;
use MetricsWave\Teams\Team;

use function Emoji\is_single_emoji;

/**
 * @property array{version: string, fields: array{name: string, value: string|array|int}} $configuration
 * @property array{id: string, label: string, checked: bool, type: string} $via
 * @mixin IdeHelperTrigger
 */
class Trigger extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const UNIQUE_VISITS = 'unique_visits';

    public const NEW_VISITS = 'new_visits';

    public const PAGE_VIEWS = 'visits';

    public const VISITS_PARAMS = [
        'path',
        'domain',
        'language',
        'userAgent',
        'platform',
        'referrer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    protected $fillable = [
        'team_id',
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

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function triggerType(): BelongsTo
    {
        return $this->belongsTo(TriggerType::class);
    }

    public function visits($tag = 'visits'): MetricsInterface
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

    public function isVisitsType(): bool
    {
        return isset($this->configuration['type'])
            && $this->configuration['type'] === 'visits';
    }

    public function isMoneyIncomeType(): bool
    {
        return isset($this->configuration['type'])
            && $this->configuration['type'] === 'money_income';
    }
}
