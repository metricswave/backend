<x-mail::message>
## {{ $article->title }}
{!! $article->short_content !!}
<p><a href="{{ $article->absoluteUrl() }}">Read more →</a></p>
</x-mail::message>
