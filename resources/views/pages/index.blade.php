@extends('layouts.landing')

@section('meta')
    <title>{{$seo_title}} - {{ config('app.name') }}</title>
    <meta content="{{ $seo_description }}"
          name="description"/>

    {{-- OG Tags --}}
    <meta property="og:url"
          content="{{ safe_url(config('app.url').request()->getPathInfo()) }}"/>
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
    @else
        <meta property="og:image"
              content="{{ safe_url(config('app.url').'/images/metricswave.png?v=20230612161011') }}"/>
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
    @else
        <meta name="twitter:image"
              content="{{ safe_url(config('app.url').'/images/metricswave.png?v=20230612161011') }}"/>
    @endif
@endsection

@section('content')
    <div class="pt-14 sm:pt-40">
        <section class="mx-auto mw-landing px-app animate-[out_1s,_fade-in-down_1.5s_ease-out_1s]">
            <h1 class="text-4xl sm:text-5xl leading-[1.3] sm:leading-[1.2] tracking-tighter">
                {!! \Illuminate\Support\Str::of($title)->replace(" \\n ", "<br>") !!}
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

        @include('partials.page_content')
    </div>

    @include('partials.prices')
@endsection

@section('scripts')
    <script>
        const internal = location.host.replace("www.", "")
        const a = document.getElementsByTagName('a')

        for (let i = 0; i < a.length; i++) {
            if (!a[i].href.includes(internal) || a[i].href.includes('/documentation')) {
                a[i].setAttribute('target', '_blank')
            }
        }
    </script>
@endsection
