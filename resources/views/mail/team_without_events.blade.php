<x-mail::message>
Hello {{ $name }},

You created a new site on MetricsWave for your domain **{{ $domain }}**, but it's not configured yet.

To do it now you just need to add the following code to your site:

@if ($uuid !== null)
```html
<script defer event-uuid="{{ $uuid }}" src="https://tracker.metricswave.com/js/visits.js"></script>
```
@endif

You can find more documentation about it in [our docs](https://metricswave.com/documentation/analytics).

If you have any questions, feel free to reply to this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
