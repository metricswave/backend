@extends('layouts.post')

@section('meta')
    <title>{{$title}} - {{ config('app.name') }}</title>
    <meta content="{{ $meta_description ?? $short_content }}"
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
          content="{{ $meta_description ?? $short_content }}"/>
    @if (isset($meta_image))
        <meta property="og:image"
              content="{{ config('app.url') }}{{ $meta_image }}"/>
    @endif

    <meta name="twitter:card"
          content="summary_large_image"/>
    <meta name="twitter:title"
          content="{{$title}} - {{ config('app.name') }}"/>
    <meta name="twitter:description"
          content="{{ $meta_description ?? $short_content }}"/>
    @if (isset($meta_image))
        <meta name="twitter:image"
              content="{{ config('app.url') }}{{ $meta_image }}"/>
    @endif
@endsection

@section('content')
    <div class="pt-14 max-w-[65ch] mx-auto">
        @if ($blueprint->raw()->handle === 'article')
            <h1 class="text-4xl sm:text-center font-bold mb-6">{{ $title }}</h1>
            <div class="sm:text-center opacity-50 mb-12">
                {{ Date::parse($date)->format('F j, Y') }}
            </div>
        @else
            <h1 class="text-4xl font-bold mb-8">{{ $title }}</h1>
        @endif

        <div class="prose dark:prose-invert mx-auto prose-headings:scroll-mt-8">
            {!! $content !!}

            @if ($blueprint->raw()->handle === 'article')
                <p class="mt-10"><a href="/blog">← Go back to the blog</a></p>
            @endif
        </div>
    </div>
@endsection
