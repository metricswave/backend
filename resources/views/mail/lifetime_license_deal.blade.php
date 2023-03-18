<x-mail::message>
Hello!

From {{ config('app.name') }}, we want to thank you for leaving your email and supporting the project.

We are preparing a public roadmap where we will explain what the first version of the project will be like and approximately when it will be launched.

In the meantime, I just want to say that if you are really interested, now **is the time to get a lifetime license**. I don't know yet what the app will cost when it is finally launched, but I can assure you that it will be more expensive than the license I am offering you now.

<x-mail::button :url="url('/leads/'.$leadUuid.'#lifetime-license')">
Get your lifetime license now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
