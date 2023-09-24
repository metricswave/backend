<x-mail::message>
You have been invited to join the {{ $invite->team->domain }} team at MetricsWave!

Click on the button below to accept the invitation and create your account.

<x-mail::button url="https://app.metricswave.com/invite/accept?utm_source=team_invite_mail&team={{ $invite->team->id }}&token={{ $invite->token }}">
Accept Invitation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
