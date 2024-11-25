<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Dashboard
 *
 * @property int $id
 * @property int $team_id
 * @property string $name
 * @property string|null $uuid
 * @property bool $public
 * @property \Spatie\LaravelData\DataCollection|null $items
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $owner
 * @property-read \MetricsWave\Teams\Team $team
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\DashboardFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard whereUuid($value)
 * @mixin \Eloquent
 */
	class IdeHelperDashboard {}
}

namespace App\Models{
/**
 * App\Models\Lead
 *
 * @property int $id
 * @property string $uuid
 * @property string $email
 * @property int|null $price_id
 * @property int $paid_price
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property bool $form_filled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\LeadFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereFormFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead wherePaidPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead wherePriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereUuid($value)
 * @mixin \Eloquent
 */
	class IdeHelperLead {}
}

namespace App\Models{
/**
 * App\Models\MailLog
 *
 * @property int $id
 * @property string $mail
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\MailLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MailLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailLog whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperMailLog {}
}

namespace App\Models{
/**
 * App\Models\Price
 *
 * @property int $id
 * @property int $price
 * @property int $remaining
 * @property \App\Transfers\PriceType $type
 * @property int $total_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PriceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Price newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Price newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Price query()
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereRemaining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereTotalAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperPrice {}
}

namespace App\Models{
/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $name
 * @property string $driver
 * @property string $description
 * @property array $scopes
 * @property bool $multiple
 * @property array|null $configuration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \MetricsWave\Users\UserService> $userServices
 * @property-read int|null $user_services_count
 * @method static \Database\Factories\ServiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service sFor()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereConfiguration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereMultiple($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperService {}
}

namespace App\Models{
/**
 * App\Models\Trigger
 *
 * @property array{version: string, fields: array{name: string, value: string|array|int}} $configuration
 * @property array{id: string, label: string, checked: bool, type: string} $via
 * @property int $id
 * @property int $team_id
 * @property int $trigger_type_id
 * @property string $uuid
 * @property string $emoji
 * @property string $title
 * @property string $content
 * @property array $configuration
 * @property array|null $via
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $time
 * @property string|null $weekdays
 * @property string|null $arrival_time
 * @property string|null $type
 * @property-read \MetricsWave\Teams\Team $team
 * @property-read \App\Models\TriggerType $triggerType
 * @method static \Database\Factories\TriggerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereArrivalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereConfiguration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereEmoji($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereTriggerTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereVia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger whereWeekdays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Trigger withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTrigger {}
}

namespace App\Models{
/**
 * App\Models\TriggerType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property array{version: string, fields: array} $configuration
 * @property array $configuration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TriggerTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType whereConfiguration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TriggerType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperTriggerType {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property bool $marketing_mailable
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $super
 * @property string|null $avatar
 * @property mixed|null $preferences
 * @property string|null $last_login
 * @property-read \Illuminate\Support\Collection $all_teams
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MailLog> $mailLogs
 * @property-read int|null $mail_logs_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \App\Models\DatabaseNotifications> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \MetricsWave\Teams\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \MetricsWave\Users\UserService> $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \MetricsWave\Teams\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMarketingMailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePreferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSuper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

namespace MetricsWave\Channels{
/**
 * MetricsWave\Channels\Channel
 *
 * @property int $id
 * @property string $name
 * @property string $driver
 * @property string $description
 * @property array $configuration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\MetricsWave\Channels\ChannelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereConfiguration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperChannel {}
}

namespace MetricsWave\Channels{
/**
 * MetricsWave\Channels\TeamChannel
 *
 * @property int $id
 * @property int $team_id
 * @property int $channel_id
 * @property array $data
 * @property string|null $data_channel_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\MetricsWave\Channels\TeamChannelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel whereDataChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamChannel withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTeamChannel {}
}

namespace MetricsWave\Metrics\Models{
/**
 * MetricsWave\Metrics\Models\Visit
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Visit query()
 * @mixin \Eloquent
 */
	class IdeHelperVisit {}
}

namespace MetricsWave\Teams{
/**
 * MetricsWave\Teams\MonthlyLimit
 *
 * @property int $id
 * @property int $team_id
 * @property int $month
 * @property int $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \MetricsWave\Teams\Team $team
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit query()
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonthlyLimit whereYear($value)
 * @mixin \Eloquent
 */
	class IdeHelperMonthlyLimit {}
}

namespace MetricsWave\Teams{
/**
 * MetricsWave\Teams\Team
 *
 * @property int $id
 * @property string $domain
 * @property int|null $owner_id
 * @property string $currency
 * @property bool $initiated
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $price_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \MetricsWave\Channels\TeamChannel> $channels
 * @property-read int|null $channels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dashboard> $dashboards
 * @property-read int|null $dashboards_count
 * @property-read string $full_subscription_plan_id
 * @property-read \App\Transfers\PlanId $subscription_plan_id
 * @property-read bool $subscription_status
 * @property-read \App\Transfers\SubscriptionType $subscription_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \MetricsWave\Teams\TeamInvite> $invites
 * @property-read int|null $invites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \MetricsWave\Teams\MonthlyLimit> $monthlyLimits
 * @property-read int|null $monthly_limits_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Trigger> $triggers
 * @property-read int|null $triggers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\MetricsWave\Teams\TeamFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Team hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|Team onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereInitiated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team wherePriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Team withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTeam {}
}

namespace MetricsWave\Teams{
/**
 * MetricsWave\Teams\TeamInvite
 *
 * @property int $id
 * @property int $team_id
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \MetricsWave\Teams\Team $team
 * @method static \Database\Factories\MetricsWave\Teams\TeamInviteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvite whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperTeamInvite {}
}

namespace MetricsWave\Users{
/**
 * MetricsWave\Users\UserCalendar
 *
 * @property int $id
 * @property int $user_id
 * @property \App\Transfers\ServiceId $service_id
 * @property string $calendar_id
 * @property string $name
 * @property string|null $description
 * @property string|null $background_color
 * @property string|null $foreground_color
 * @property string $time_zone
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \MetricsWave\Users\UserService|null $service
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\MetricsWave\Users\UserCalendarFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereCalendarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereForegroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereTimeZone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCalendar withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperUserCalendar {}
}

namespace MetricsWave\Users{
/**
 * MetricsWave\Users\UserService
 *
 * @property int $id
 * @property int $user_id
 * @property int $service_id
 * @property int $reconectable
 * @property array $service_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $channel_id
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\MetricsWave\Users\UserServiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserService onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserService query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereReconectable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereServiceData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserService withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperUserService {}
}

