<x-mail::message>
Hi!

We keep moving forward! From all the answers to the survey (you can find it on your personal screen when you leave your email) we have prepared the roadmap.

We want to be totally transparent so that you know what features {{ config('app.name') }} will have and when the first version will be available (Jun 2023).

@if ($hasLicense === false)
On the other hand, we recommend that you take a look at our [lifetime licenses]({{ url('/leads/'.$leadUuid.'#lifetime-license') }}). Now is a unique opportunity to get yours at the best price - there are practically none left at $29.50!
@endif

<x-mail::button :url="url('/roadmap')">
Checkout the roadmap
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
