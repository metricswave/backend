<x-mail::message>
## {{ $article->title }}
{!! $article->short_content !!}
<p><a href="{{ config('app.url') }}/blog/{{ $article->slug }}">Read more →</a></p>
</x-mail::message>
