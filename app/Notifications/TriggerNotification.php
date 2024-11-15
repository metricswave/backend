<?php

namespace App\Notifications;

use App\Models\Trigger;
use App\Services\CacheKey;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Str;

class TriggerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public readonly string $title;

    public readonly string $content;

    public readonly string $emoji;

    public readonly ?string $userParam;

    public readonly ?int $teamId;

    public ?CarbonImmutable $notifiedAt = null;

    public function __construct(
        public readonly Trigger $trigger,
        public readonly array $params = [],
        CarbonImmutable $notifiedAt = null,
    ) {
        if (isset($params['amount']) && $trigger->isMoneyIncomeType()) {
            $params['amount'] = $this->formatMoneyAmount((int) $params['amount']);
        }

        $this->title = $trigger->formattedTitle($params);
        $this->content = $trigger->formattedContent($params);
        $this->emoji = $trigger->formattedEmoji($params);
        $this->notifiedAt = $notifiedAt ?? CarbonImmutable::now();
        $this->userParam = $params['user'] ?? $params['userId'] ?? $params['user_id'] ?? $params['user-id'] ?? null;
        $this->teamId = $trigger->team_id;
    }

    public function via(object $notifiable): array
    {
        $notifiedAt = $this->notifiedAt ?? CarbonImmutable::now();

        $params = $this->params;

        $inc = 1;
        if ($this->trigger->isMoneyIncomeType()) {
            $inc = $params['amount'] ?? 1;
        }

        $this->trigger->visits()->increment(inc: $inc, date: $notifiedAt);

        if ($this->trigger->isVisitsType()) {
            if (isset($params['deviceName'])) {
                $cacheKey = CacheKey::generateForModel($this->trigger, ['unique', $params['deviceName']]);
                unset($params['deviceName']);

                if (! Cache::has($cacheKey)) {
                    $this->trigger->visits(Trigger::UNIQUE_VISITS)->increment(date: $notifiedAt);
                    Cache::put($cacheKey, true, now()->endOfDay());
                }
            }

            if (isset($params['visit'])) {
                if ($params['visit'] === 1 || $params['visit'] === '1') {
                    $this->trigger->visits(Trigger::NEW_VISITS)->increment(date: $notifiedAt);
                }
                unset($params['visit']);
            }

            if (
                empty($params['referrer'])
                || (
                    isset($params['domain'])
                    && Str::of($params['referrer'])->contains($params['domain'])
                )
            ) {
                $params['referrer'] = 'Direct / None';
            }
        }

        $this->trigger->visits()->recordParams($params, inc: $inc, date: $notifiedAt);

        $via = collect($this->trigger->via)
            ->filter(fn ($via) => $via['checked'] && $via['type'] !== 'telegram')
            ->unique('type')
            ->map(fn ($via) => $via['type'])
            ->toArray();

        return [
            'database',
            ...$via,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'emoji' => $this->emoji,
            'trigger_id' => $this->trigger->id,
            'trigger_type_id' => $this->trigger->trigger_type_id,
            'user_parameter' => $this->userParam,
            'team_id' => $this->teamId,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->trigger->emoji.' '.$this->title)
            ->markdown('mail.trigger', [
                'emoji' => $this->emoji,
                'title' => $this->title,
                'content' => $this->content,
            ]);
    }

    private function formatMoneyAmount(int $amount): string
    {
        $money = new Money($amount, new Currency($this->trigger->team->preferredCurrency()));
        $currencies = new ISOCurrencies;

        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}
