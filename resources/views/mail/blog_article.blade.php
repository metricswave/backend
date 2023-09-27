<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
# {{ $article->title }}
{!! Statamic::modify($article->content)->fullUrls() !!}

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.') @if($token !== null) | <a href="{{ safe_url(config('app.web_app_url').'/unsubscribe').'?token='.$token }}">Unsubscribe</a>@endif
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
