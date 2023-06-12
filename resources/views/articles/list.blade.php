@extends('layouts.post')

@section('meta')
    <title>{{$title}} - {{ config('app.name') }}</title>
    <meta content="{{ $meta_description }}"
          name="description"/>

    {{-- OG Tags --}}
    <meta property="og:url"
          content="{{ config('app.url') }}"/>
    <meta property="og:locale"
          content="en_US"/>
    <meta property="og:type"
          content="article"/>
    <meta property="og:title"
          content="{{$title}} - {{ config('app.name') }}"/>
    <meta property="og:description"
          content="{{ $meta_description }}"/>
    <meta property="og:image"
          content="{{ config('app.url') }}/images/metricswave.png?v=20230612161011"/>

    <meta name="twitter:card"
          content="summary_large_image"/>
    <meta name="twitter:title"
          content="{{$title}} - {{ config('app.name') }}"/>
    <meta name="twitter:description"
          content="{{ $meta_description }}"/>
    <meta name="twitter:creator"
          content="@get_monse"/>
    <meta name="twitter:image"
          content="{{ config('app.url') }}/images/metricswave.png?v=20230612161011"/>
@endsection

@section('content')
    <div class="pt-14 max-w-[65ch] mx-auto">
        <h1 class="text-4xl sm:text-center font-bold mb-6">{{ $title }}</h1>
        <div class="sm:text-center opacity-50 pb-24">
            Here you can find all the updates and articles about {{ config('app.name') }}.
        </div>

        <div class="flex flex-col space-y-14 sm:space-y-20">
            @foreach($articles as $article)
                <div class="max-w-[65ch] mx-auto">
                    <h2 class="text-2xl font-bold mb-2">
                        <a href="/blog/{{ $article->slug }}">
                            {{ $article->title }}
                        </a>
                    </h2>
                    <div class="opacity-50 mb-4">
                        {{ Date::parse($article->date)->format('F j, Y') }}
                    </div>

                    <div class="prose dark:prose-invert mx-auto">
                        {!! $article->short_content !!}
                        <p><a href="/blog/{{ $article->slug }}">Read more →</a></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
