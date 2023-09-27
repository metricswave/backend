<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{use Database\Factories\DashboardFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;
    use MetricsWave\Teams\Team;
    use Spatie\LaravelData\DataCollection;

    /**
     * App\Models\Dashboard
     *
     * @property int $id
     * @property int $team_id
     * @property string $name
     * @property string|null $uuid
     * @property bool $public
     * @property DataCollection|null $items
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read User|null $owner
     * @property-read Team $team
     * @property-read Collection<int, User> $users
     * @property-read int|null $users_count
     *
     * @method static DashboardFactory factory($count = null, $state = [])
     * @method static Builder|Dashboard newModelQuery()
     * @method static Builder|Dashboard newQuery()
     * @method static Builder|Dashboard query()
     * @method static Builder|Dashboard whereCreatedAt($value)
     * @method static Builder|Dashboard whereId($value)
     * @method static Builder|Dashboard whereItems($value)
     * @method static Builder|Dashboard whereName($value)
     * @method static Builder|Dashboard wherePublic($value)
     * @method static Builder|Dashboard whereTeamId($value)
     * @method static Builder|Dashboard whereUpdatedAt($value)
     * @method static Builder|Dashboard whereUuid($value)
     */
    class Dashboard extends Eloquent
    {
    }
}

namespace App\Models{use Database\Factories\LeadFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * App\Models\Lead
     *
     * @property int $id
     * @property string $uuid
     * @property string $email
     * @property int|null $price_id
     * @property int $paid_price
     * @property Carbon|null $paid_at
     * @property bool $form_filled
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     *
     * @method static LeadFactory factory($count = null, $state = [])
     * @method static Builder|Lead newModelQuery()
     * @method static Builder|Lead newQuery()
     * @method static Builder|Lead query()
     * @method static Builder|Lead whereCreatedAt($value)
     * @method static Builder|Lead whereEmail($value)
     * @method static Builder|Lead whereFormFilled($value)
     * @method static Builder|Lead whereId($value)
     * @method static Builder|Lead wherePaidAt($value)
     * @method static Builder|Lead wherePaidPrice($value)
     * @method static Builder|Lead wherePriceId($value)
     * @method static Builder|Lead whereUpdatedAt($value)
     * @method static Builder|Lead whereUuid($value)
     */
    class Lead extends Eloquent
    {
    }
}

namespace App\Models{use Database\Factories\MailLogFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * App\Models\MailLog
     *
     * @property int $id
     * @property string $mail
     * @property string $type
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     *
     * @method static MailLogFactory factory($count = null, $state = [])
     * @method static Builder|MailLog newModelQuery()
     * @method static Builder|MailLog newQuery()
     * @method static Builder|MailLog query()
     * @method static Builder|MailLog whereCreatedAt($value)
     * @method static Builder|MailLog whereId($value)
     * @method static Builder|MailLog whereMail($value)
     * @method static Builder|MailLog whereType($value)
     * @method static Builder|MailLog whereUpdatedAt($value)
     */
    class MailLog extends Eloquent
    {
    }
}

namespace App\Models{use App\Transfers\PriceType;
    use Database\Factories\PriceFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * App\Models\Price
     *
     * @property int $id
     * @property int $price
     * @property int $remaining
     * @property PriceType $type
     * @property int $total_available
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     *
     * @method static PriceFactory factory($count = null, $state = [])
     * @method static Builder|Price newModelQuery()
     * @method static Builder|Price newQuery()
     * @method static Builder|Price query()
     * @method static Builder|Price whereCreatedAt($value)
     * @method static Builder|Price whereId($value)
     * @method static Builder|Price wherePrice($value)
     * @method static Builder|Price whereRemaining($value)
     * @method static Builder|Price whereTotalAvailable($value)
     * @method static Builder|Price whereType($value)
     * @method static Builder|Price whereUpdatedAt($value)
     */
    class Price extends Eloquent
    {
    }
}

namespace App\Models{use Database\Factories\ServiceFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;
    use MetricsWave\Users\UserService;

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
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Collection<int, UserService> $userServices
     * @property-read int|null $user_services_count
     *
     * @method static ServiceFactory factory($count = null, $state = [])
     * @method static Builder|Service newModelQuery()
     * @method static Builder|Service newQuery()
     * @method static Builder|Service query()
     * @method static Builder|Service sFor()
     * @method static Builder|Service whereConfiguration($value)
     * @method static Builder|Service whereCreatedAt($value)
     * @method static Builder|Service whereDescription($value)
     * @method static Builder|Service whereDriver($value)
     * @method static Builder|Service whereId($value)
     * @method static Builder|Service whereMultiple($value)
     * @method static Builder|Service whereName($value)
     * @method static Builder|Service whereScopes($value)
     * @method static Builder|Service whereUpdatedAt($value)
     */
    class Service extends Eloquent
    {
    }
}

namespace App\Models{use Database\Factories\TriggerFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;
    use MetricsWave\Teams\Team;

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
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property string|null $time
     * @property string|null $weekdays
     * @property string|null $arrival_time
     * @property string|null $type
     * @property-read Team $team
     * @property-read TriggerType $triggerType
     *
     * @method static TriggerFactory factory($count = null, $state = [])
     * @method static Builder|Trigger newModelQuery()
     * @method static Builder|Trigger newQuery()
     * @method static Builder|Trigger onlyTrashed()
     * @method static Builder|Trigger query()
     * @method static Builder|Trigger whereArrivalTime($value)
     * @method static Builder|Trigger whereConfiguration($value)
     * @method static Builder|Trigger whereContent($value)
     * @method static Builder|Trigger whereCreatedAt($value)
     * @method static Builder|Trigger whereDeletedAt($value)
     * @method static Builder|Trigger whereEmoji($value)
     * @method static Builder|Trigger whereId($value)
     * @method static Builder|Trigger whereTeamId($value)
     * @method static Builder|Trigger whereTime($value)
     * @method static Builder|Trigger whereTitle($value)
     * @method static Builder|Trigger whereTriggerTypeId($value)
     * @method static Builder|Trigger whereType($value)
     * @method static Builder|Trigger whereUpdatedAt($value)
     * @method static Builder|Trigger whereUuid($value)
     * @method static Builder|Trigger whereVia($value)
     * @method static Builder|Trigger whereWeekdays($value)
     * @method static Builder|Trigger withTrashed()
     * @method static Builder|Trigger withoutTrashed()
     */
    class Trigger extends Eloquent
    {
    }
}

namespace App\Models{use Database\Factories\TriggerTypeFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * App\Models\TriggerType
     *
     * @property int $id
     * @property string $name
     * @property string $description
     * @property string $icon
     * @property array{version: string, fields: array} $configuration
     * @property array $configuration
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     *
     * @method static TriggerTypeFactory factory($count = null, $state = [])
     * @method static Builder|TriggerType newModelQuery()
     * @method static Builder|TriggerType newQuery()
     * @method static Builder|TriggerType query()
     * @method static Builder|TriggerType whereConfiguration($value)
     * @method static Builder|TriggerType whereCreatedAt($value)
     * @method static Builder|TriggerType whereDescription($value)
     * @method static Builder|TriggerType whereIcon($value)
     * @method static Builder|TriggerType whereId($value)
     * @method static Builder|TriggerType whereName($value)
     * @method static Builder|TriggerType whereUpdatedAt($value)
     */
    class TriggerType extends Eloquent
    {
    }
}

namespace MetricsWave\Channels{use Database\Factories\MetricsWave\Channels\ChannelFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * MetricsWave\Channels\Channel
     *
     * @property int $id
     * @property string $name
     * @property string $driver
     * @property string $description
     * @property array $configuration
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     *
     * @method static ChannelFactory factory($count = null, $state = [])
     * @method static Builder|Channel newModelQuery()
     * @method static Builder|Channel newQuery()
     * @method static Builder|Channel query()
     * @method static Builder|Channel whereConfiguration($value)
     * @method static Builder|Channel whereCreatedAt($value)
     * @method static Builder|Channel whereDescription($value)
     * @method static Builder|Channel whereDriver($value)
     * @method static Builder|Channel whereId($value)
     * @method static Builder|Channel whereName($value)
     * @method static Builder|Channel whereUpdatedAt($value)
     */
    class Channel extends Eloquent
    {
    }
}

namespace MetricsWave\Channels{use Database\Factories\MetricsWave\Channels\TeamChannelFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * MetricsWave\Channels\TeamChannel
     *
     * @property int $id
     * @property int $team_id
     * @property int $channel_id
     * @property array $data
     * @property string|null $data_channel_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     *
     * @method static TeamChannelFactory factory($count = null, $state = [])
     * @method static Builder|TeamChannel newModelQuery()
     * @method static Builder|TeamChannel newQuery()
     * @method static Builder|TeamChannel onlyTrashed()
     * @method static Builder|TeamChannel query()
     * @method static Builder|TeamChannel whereChannelId($value)
     * @method static Builder|TeamChannel whereCreatedAt($value)
     * @method static Builder|TeamChannel whereData($value)
     * @method static Builder|TeamChannel whereDataChannelId($value)
     * @method static Builder|TeamChannel whereDeletedAt($value)
     * @method static Builder|TeamChannel whereId($value)
     * @method static Builder|TeamChannel whereTeamId($value)
     * @method static Builder|TeamChannel whereUpdatedAt($value)
     * @method static Builder|TeamChannel withTrashed()
     * @method static Builder|TeamChannel withoutTrashed()
     */
    class TeamChannel extends Eloquent
    {
    }
}

namespace MetricsWave\Metrics\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * MetricsWave\Metrics\Models\Visit
     *
     * @property int $id
     * @property string $primary_key
     * @property string|null $secondary_key
     * @property int $score
     * @property array|null $list
     * @property Carbon|null $expired_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     *
     * @method static Builder|Visit newModelQuery()
     * @method static Builder|Visit newQuery()
     * @method static Builder|Visit query()
     * @method static Builder|Visit whereCreatedAt($value)
     * @method static Builder|Visit whereExpiredAt($value)
     * @method static Builder|Visit whereId($value)
     * @method static Builder|Visit whereList($value)
     * @method static Builder|Visit wherePrimaryKey($value)
     * @method static Builder|Visit whereScore($value)
     * @method static Builder|Visit whereSecondaryKey($value)
     * @method static Builder|Visit whereUpdatedAt($value)
     */
    class Visit extends Eloquent
    {
    }
}

namespace MetricsWave\Teams{use App\Models\Dashboard;
    use App\Models\Trigger;
    use App\Models\User;
    use App\Transfers\PlanId;
    use App\Transfers\SubscriptionType;
    use Database\Factories\MetricsWave\Teams\TeamFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;
    use Laravel\Cashier\Subscription;
    use MetricsWave\Channels\TeamChannel;

    /**
     * MetricsWave\Teams\Team
     *
     * @property int $id
     * @property string $domain
     * @property int|null $owner_id
     * @property bool $initiated
     * @property string|null $stripe_id
     * @property string|null $pm_type
     * @property string|null $pm_last_four
     * @property string|null $trial_ends_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property int|null $price_id
     * @property-read Collection<int, TeamChannel> $channels
     * @property-read int|null $channels_count
     * @property-read Collection<int, Dashboard> $dashboards
     * @property-read int|null $dashboards_count
     * @property-read PlanId $subscription_plan_id
     * @property-read bool $subscription_status
     * @property-read SubscriptionType $subscription_type
     * @property-read Collection<int, TeamInvite> $invites
     * @property-read int|null $invites_count
     * @property-read User|null $owner
     * @property-read Collection<int, Subscription> $subscriptions
     * @property-read int|null $subscriptions_count
     * @property-read Collection<int, Trigger> $triggers
     * @property-read int|null $triggers_count
     * @property-read Collection<int, User> $users
     * @property-read int|null $users_count
     *
     * @method static TeamFactory factory($count = null, $state = [])
     * @method static Builder|Team hasExpiredGenericTrial()
     * @method static Builder|Team newModelQuery()
     * @method static Builder|Team newQuery()
     * @method static Builder|Team onGenericTrial()
     * @method static Builder|Team query()
     * @method static Builder|Team whereCreatedAt($value)
     * @method static Builder|Team whereDomain($value)
     * @method static Builder|Team whereId($value)
     * @method static Builder|Team whereInitiated($value)
     * @method static Builder|Team whereOwnerId($value)
     * @method static Builder|Team wherePmLastFour($value)
     * @method static Builder|Team wherePmType($value)
     * @method static Builder|Team wherePriceId($value)
     * @method static Builder|Team whereStripeId($value)
     * @method static Builder|Team whereTrialEndsAt($value)
     * @method static Builder|Team whereUpdatedAt($value)
     */
    class Team extends Eloquent
    {
    }
}

namespace MetricsWave\Teams{use Database\Factories\MetricsWave\Teams\TeamInviteFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * MetricsWave\Teams\TeamInvite
     *
     * @property int $id
     * @property int $team_id
     * @property string $email
     * @property string $token
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Team $team
     *
     * @method static TeamInviteFactory factory($count = null, $state = [])
     * @method static Builder|TeamInvite newModelQuery()
     * @method static Builder|TeamInvite newQuery()
     * @method static Builder|TeamInvite query()
     * @method static Builder|TeamInvite whereCreatedAt($value)
     * @method static Builder|TeamInvite whereEmail($value)
     * @method static Builder|TeamInvite whereId($value)
     * @method static Builder|TeamInvite whereTeamId($value)
     * @method static Builder|TeamInvite whereToken($value)
     * @method static Builder|TeamInvite whereUpdatedAt($value)
     */
    class TeamInvite extends Eloquent
    {
    }
}

namespace MetricsWave\Users{use App\Models\MailLog;
    use Database\Factories\UserFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Notifications\DatabaseNotification;
    use Illuminate\Notifications\DatabaseNotificationCollection;
    use Illuminate\Support\Carbon;
    use Laravel\Sanctum\PersonalAccessToken;
    use MetricsWave\Teams\Team;

    /**
     * MetricsWave\Users\User
     *
     * @property int $id
     * @property string $name
     * @property string $email
     * @property Carbon|null $email_verified_at
     * @property string|null $password
     * @property string|null $remember_token
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property int $super
     * @property string|null $avatar
     * @property mixed|null $preferences
     * @property string|null $last_login
     * @property-read \Illuminate\Support\Collection $all_teams
     * @property-read Collection<int, MailLog> $mailLogs
     * @property-read int|null $mail_logs_count
     * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
     * @property-read int|null $notifications_count
     * @property-read Collection<int, Team> $ownedTeams
     * @property-read int|null $owned_teams_count
     * @property-read Collection<int, UserService> $services
     * @property-read int|null $services_count
     * @property-read Collection<int, Team> $teams
     * @property-read int|null $teams_count
     * @property-read Collection<int, PersonalAccessToken> $tokens
     * @property-read int|null $tokens_count
     *
     * @method static UserFactory factory($count = null, $state = [])
     * @method static Builder|\App\Models\User newModelQuery()
     * @method static Builder|\App\Models\User newQuery()
     * @method static Builder|\App\Models\User query()
     * @method static Builder|\App\Models\User whereAvatar($value)
     * @method static Builder|\App\Models\User whereCreatedAt($value)
     * @method static Builder|\App\Models\User whereEmail($value)
     * @method static Builder|\App\Models\User whereEmailVerifiedAt($value)
     * @method static Builder|\App\Models\User whereId($value)
     * @method static Builder|\App\Models\User whereLastLogin($value)
     * @method static Builder|\App\Models\User whereName($value)
     * @method static Builder|\App\Models\User wherePassword($value)
     * @method static Builder|\App\Models\User wherePreferences($value)
     * @method static Builder|\App\Models\User whereRememberToken($value)
     * @method static Builder|\App\Models\User whereSuper($value)
     * @method static Builder|\App\Models\User whereUpdatedAt($value)
     */
    class User extends Eloquent
    {
    }
}

namespace MetricsWave\Users{use App\Transfers\ServiceId;
    use Database\Factories\MetricsWave\Users\UserCalendarFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * MetricsWave\Users\UserCalendar
     *
     * @property int $id
     * @property int $user_id
     * @property ServiceId $service_id
     * @property string $calendar_id
     * @property string $name
     * @property string|null $description
     * @property string|null $background_color
     * @property string|null $foreground_color
     * @property string $time_zone
     * @property Carbon|null $deleted_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read UserService|null $service
     * @property-read \App\Models\User|null $user
     *
     * @method static UserCalendarFactory factory($count = null, $state = [])
     * @method static Builder|UserCalendar newModelQuery()
     * @method static Builder|UserCalendar newQuery()
     * @method static Builder|UserCalendar onlyTrashed()
     * @method static Builder|UserCalendar query()
     * @method static Builder|UserCalendar whereBackgroundColor($value)
     * @method static Builder|UserCalendar whereCalendarId($value)
     * @method static Builder|UserCalendar whereCreatedAt($value)
     * @method static Builder|UserCalendar whereDeletedAt($value)
     * @method static Builder|UserCalendar whereDescription($value)
     * @method static Builder|UserCalendar whereForegroundColor($value)
     * @method static Builder|UserCalendar whereId($value)
     * @method static Builder|UserCalendar whereName($value)
     * @method static Builder|UserCalendar whereServiceId($value)
     * @method static Builder|UserCalendar whereTimeZone($value)
     * @method static Builder|UserCalendar whereUpdatedAt($value)
     * @method static Builder|UserCalendar whereUserId($value)
     * @method static Builder|UserCalendar withTrashed()
     * @method static Builder|UserCalendar withoutTrashed()
     */
    class UserCalendar extends Eloquent
    {
    }
}

namespace MetricsWave\Users{use Database\Factories\MetricsWave\Users\UserServiceFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * MetricsWave\Users\UserService
     *
     * @property int $id
     * @property int $user_id
     * @property int $service_id
     * @property int $reconectable
     * @property array $service_data
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property string|null $channel_id
     * @property-read \App\Models\User $user
     *
     * @method static UserServiceFactory factory($count = null, $state = [])
     * @method static Builder|UserService newModelQuery()
     * @method static Builder|UserService newQuery()
     * @method static Builder|UserService onlyTrashed()
     * @method static Builder|UserService query()
     * @method static Builder|UserService whereChannelId($value)
     * @method static Builder|UserService whereCreatedAt($value)
     * @method static Builder|UserService whereDeletedAt($value)
     * @method static Builder|UserService whereId($value)
     * @method static Builder|UserService whereReconectable($value)
     * @method static Builder|UserService whereServiceData($value)
     * @method static Builder|UserService whereServiceId($value)
     * @method static Builder|UserService whereUpdatedAt($value)
     * @method static Builder|UserService whereUserId($value)
     * @method static Builder|UserService withTrashed()
     * @method static Builder|UserService withoutTrashed()
     */
    class UserService extends Eloquent
    {
    }
}
