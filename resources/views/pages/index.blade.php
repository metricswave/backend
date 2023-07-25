@extends('layouts.landing')

@section('meta')
    <title>{{$seo_title}} - {{ config('app.name') }}</title>
    <meta content="{{ $seo_description }}"
          name="description"/>

    {{-- OG Tags --}}
    <meta property="og:url"
          content="{{ config('app.url') }}"/>
    <meta property="og:locale"
          content="en_US"/>
    <meta property="og:type"
          content="article"/>
    <meta property="og:title"
          content="{{$seo_title}} - {{ config('app.name') }}"/>
    <meta property="og:description"
          content="{{ $seo_description }}"/>
    @if (isset($og_image))
        <meta property="og:image"
              content="{{ $og_image }}"/>
    @endif

    <meta name="twitter:card"
          content="summary_large_image"/>
    <meta name="twitter:title"
          content="{{$seo_title}} - {{ config('app.name') }}"/>
    <meta name="twitter:description"
          content="{{ $seo_description }}"/>
    @if (isset($og_image))
        <meta name="twitter:image"
              content="{{ $og_image }}"/>
    @endif
@endsection

@section('content')
    <div class="pt-14 sm:pt-40">
        <section class="mx-auto mw-landing px-app animate-[out_1s,_fade-in-down_1.5s_ease-out_1s]">
            <h1 class="text-4xl sm:text-5xl leading-[1.3] sm:leading-[1.2] tracking-tighter">
                {{ $title }}
            </h1>

            @if(Str::of($hero_content)->length() > 0)
                <div class="prose dark:prose-invert prose-lg mt-5">
                    {!! $hero_content !!}
                </div>
            @endif

            @if($show_buttons)
                <div class="flex flex-col sm:flex-row items-center justify-start gap-6 mt-8">
                    <a
                        class="py-4 px-6 text-center bg-gradient-to-b from-slate-800 via-black to-black dark:from-zinc-800 dark:via-zinc-800 dark:to-zinc-800 hover:bg-gradient-to-b hover:from-slate-600 hover:via-slate-900 hover:to-black hover:dark:from-zinc-700 hover:dark:via-zinc-700 hover:dark:to-zinc-700 text-white block ml-0 rounded-lg shadow-lg hover:shadow smooth linkToApp w-full sm:w-auto"
                        href="{{ config('app.web_app_url') }}"
                    >
                        {!! $buttonText ?? 'Start Tracking <span class="hidden md:inline">my Product </span>for Free →' !!}
                    </a>

                    <a
                        class="py-4 px-6 opacity-60 hover:opacity-100 smooth border rounded-lg w-full sm:w-auto text-center"
                        href="https://app.metricswave.com/fUwWlrz6Xhedh12/metricswave.com?compare=1&period=7d"
                        target="_blank"
                    >
                        Live Demo
                    </a>
                </div>
            @endif
        </section>

        {{-- w-10 dark:text-orange-500 h-auto animate-[out_1.5s,_fade-in-down_2s_ease-out_1s] animate-[out_2s,_fade-in-down_2.5s_ease-out_1s] animate-[out_2.5s,_fade-in-down_3s_ease-out_1s] animate-[out_3s,_fade-in-down_3.5s_ease-out_1s] --}}
        <div class="flex flex-col gap-8 md:gap-32 mt-16 md:mt-32">
            @foreach($structured_content as $i => $content)
                @php
                    $out =  min(3, 1.5 + ($i * 0.5));
                    $fade = $out + 0.5;
                @endphp

                @if($content['type'] === 'features')
                    <section class="mx-auto mw-landing px-app animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s]">
                        @if (Str::of($content['title'])->length() > 0)
                            <h2 class="font-bold text-2xl pb-4">
                                {{ $content['title'] }}
                            </h2>
                        @endif

                        @if(Str::of($content['short_description'])->length() > 0)
                            {!! $content['short_description'] !!}
                        @endif

                        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-x-8 md:gap-y-10">
                            @foreach($content['grid'] as $grid)
                                <div class="flex flex-col gap-2">
                                    <div class="-ml-1">{!! $grid['icon'] !!}</div>
                                    <h3 class="font-bold text-lg">{{ $grid['title'] }}</h3>
                                    {!! $grid['content'] !!}
                                </div>
                            @endforeach
                        </div>
                    </section>
                @elseif($content['type'] === 'section')
                    <section class="mx-auto mw-landing px-app prose dark:prose-invert animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s]">
                        <h2>{{ $content['title'] }}</h2>
                        {!! $content['content'] !!}
                    </section>
                @elseif($content['type'] === 'section_with_image')
                    <section class="mx-auto w-full soft-border border-b animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s]">
                        <div class="mw-landing mx-auto mb-16 px-app">
                            <h2 class="text-2xl font-bold mb-4 !leading-snug">{{ $content['title'] }}</h2>
                            <div class="prose dark:prose-invert">
                                {!! $content['content'] !!}
                            </div>
                        </div>
                        <div>
                            <img src="{{ $content['image'] }}"
                                 alt="{{ $content['title'] }}"
                                 class="max-w-full mx-auto dark:hidden"/>
                            <img src="{{ $content['dark_image'] }}"
                                 alt="{{ $content['title'] }}"
                                 class="max-w-full mx-auto hidden dark:block"/>
                        </div>
                    </section>
                @endif
            @endforeach
        </div>
    </div>

    @include('partials.prices')
@endsection
