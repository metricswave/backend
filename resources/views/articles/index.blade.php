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
          content="{{ config('app.url') }}{{ $meta_image }}"/>

    <meta name="twitter:card"
          content="summary_large_image"/>
    <meta name="twitter:title"
          content="{{$title}} - {{ config('app.name') }}"/>
    <meta name="twitter:description"
          content="{{ $meta_description }}"/>
    <meta name="twitter:creator"
          content="@get_monse"/>
    <meta name="twitter:image"
          content="{{ config('app.url') }}{{ $meta_image }}"/>
@endsection

@section('content')
    <div class="pt-14 mw-landing mx-auto">
        <h1 class="text-4xl sm:text-center font-bold mb-6">{{ $title }}</h1>
        <div class="sm:text-center opacity-50 mb-12">
            {{ Date::parse($updated_at)->format('F j, Y') }}
        </div>

        <div class="prose dark:prose-invert mx-auto">
            {!! $content !!}
        </div>
    </div>
@endsection
