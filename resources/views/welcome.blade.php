@extends('layouts.landing')

@section('meta')
    <title>{{$page->seo_title}} - {{ config('app.name') }}</title>
    <meta content="{{ $page->seo_description }}"
          name="description"/>

    {{-- OG Tags --}}
    <meta property="og:url"
          content="{{ config('app.url') }}"/>
    <meta property="og:locale"
          content="en_US"/>
    <meta property="og:type"
          content="article"/>
    <meta property="og:title"
          content="{{$page->seo_title}} - {{ config('app.name') }}"/>
    <meta property="og:description"
          content="{{ $page->seo_description }}"/>
    @if(isset($page->og_image))
        <meta property="og:image"
              content="{{ $page->og_image }}"/>
    @else
        <meta property="og:image"
              content="{{ safe_url(config('app.url').'/images/metricswave.png?v=20230612161011') }}"/>
    @endif

    <meta name="twitter:card"
          content="summary_large_image"/>
    <meta name="twitter:title"
          content="{{$page->seo_title}} - {{ config('app.name') }}"/>
    <meta name="twitter:description"
          content="{{ $page->seo_description }}"/>
    @if(isset($page->og_image))
        <meta name="twitter:image"
              content="{{ $page->og_image }}"/>
    @else
        <meta property="twitter:image"
              content="{{ safe_url(config('app.url').'/images/metricswave.png?v=20230612161011') }}"/>
    @endif
@endsection

@section('content')
    <div class="flex flex-col items-center justify-center space-y-14 sm:space-y-32">
        <div class="px-[var(--app-padding)] sm:px-0 mw-landing mx-auto my-10 w-full flex flex-col space-y-8 sm:my-40">
            <h1 class="animate-[out_1s,_fade-in-down_1.5s_ease-out_1s] text-3xl sm:text-6xl leading-[1.3] sm:leading-[1.1] tracking-tighter max-w-[22ch]">
                Best Google Analytics alternative for
                <br/><span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">Your Product</span>.
            </h1>

            <div class="animate-[out_1.25s,_fade-in-down_1.5s_ease-out_1.25s] text-lg font-light !leading-normal sm:text-2xl prose sm:prose-xl dark:prose-invert">
                {!! $page->hero_content !!}
            </div>

            <div class="">
                @if(config('feature.sign_up_leads_only'))
                    @include('landing.lead-form')
                @else
                    <div class="flex flex-col sm:flex-row items-center justify-start gap-6 animate-[out_1.75s,_fade-in-down_1.5s_ease-out_1.75s]">
                        <a
                            class="py-4 px-6 text-center bg-gradient-to-b from-slate-800 via-black to-black dark:from-zinc-800 dark:via-zinc-800 dark:to-zinc-800 hover:bg-gradient-to-b hover:from-slate-600 hover:via-slate-900 hover:to-black hover:dark:from-zinc-700 hover:dark:via-zinc-700 hover:dark:to-zinc-700 text-white block ml-0 rounded-lg shadow-lg hover:shadow smooth linkToApp w-full sm:w-auto"
                            href="{{ config('app.web_app_url') }}"
                        >
                            {!!
                              $buttonText ??
                              'Start Tracking <span class="hidden md:inline">my Product </span>for Free →'
                            !!}
                        </a>

                        <a
                            class="py-4 px-6 opacity-60 hover:opacity-100 smooth border rounded-lg w-full sm:w-auto text-center metricswave-event-uuid--6337915a-0498-4e42-baeb-ad57b9bcc541 metricswave-event-param-location--Hero"
                            href="https://app.metricswave.com/fUwWlrz6Xhedh12/metricswave.com?compare=1&period=7d"
                            target="_blank"
                        >
                            Live Demo
                        </a>
                    </div>

                    @if(count($page->partner_logos) > 0)
                        <div class="animate-[out_2s,_fade-in-down_1.5s_ease-out_2s]">
                            <div class="flex flex-row items-start gap-5 pt-20 opacity-70">
                                <h6>Some of our customers</h6>
                            </div>
                            <div class="flex flex-row items-center justify-start gap-5 pt-5 pb-0">
                                @foreach($page->partner_logos ?? [] as $i => $logo)
                                    <a href="{{ $logo->url }}"
                                       class="scale-95 grayscale transition-all duration-300 hover:grayscale-0 hover:scale-100 dark:hidden max-w-[150px] h-auto">
                                        <img src="{{ $logo->logo }}"
                                             alt="{{ $logo->title }}"
                                             class="max-w-full mx-auto"/>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>

        <div id="eu"
             class="animate-[out_2.25s,_fade-in-down_1.5s_ease-out_2.25s] relative w-full border-b soft-border px-app !mt-0">
            <div class="mw-landing mx-auto mb-16 sm:mb-32">
                <h2 class="text-2xl sm:text-3xl font-medium mb-4 !leading-snug max-w-[30ch]">
                    No cookies, fully compliant with GDPR, CCPA and PECR.
                </h2>
                <div class="prose md:prose-lg dark:prose-invert">
                    <p>We don't use cookies, we don't store any personal data, and we don't track your users across
                        websites.</p>
                    <p>Made and hosted in the EU 🇪🇺.</p>
                </div>
            </div>
        </div>
    </div>

    @include('partials.page_content', [
        'structured_content' => $page->structured_content,
    ])

    @include('partials.prices')
@endsection

@section('scripts')
    <script>
        const EU_TIMEZONES = [
            'Europe/Vienna',
            'Europe/Brussels',
            'Europe/Sofia',
            'Europe/Zagreb',
            'Asia/Famagusta',
            'Asia/Nicosia',
            'Europe/Prague',
            'Europe/Copenhagen',
            'Europe/Tallinn',
            'Europe/Helsinki',
            'Europe/Paris',
            'Europe/Berlin',
            'Europe/Busingen',
            'Europe/Athens',
            'Europe/Budapest',
            'Europe/Dublin',
            'Europe/Rome',
            'Europe/Riga',
            'Europe/Vilnius',
            'Europe/Luxembourg',
            'Europe/Malta',
            'Europe/Amsterdam',
            'Europe/Warsaw',
            'Atlantic/Azores',
            'Atlantic/Madeira',
            'Europe/Lisbon',
            'Europe/Bucharest',
            'Europe/Bratislava',
            'Europe/Ljubljana',
            'Africa/Ceuta',
            'Atlantic/Canary',
            'Europe/Madrid',
            'Europe/Stockholm'
        ]

        const isFromEu = () => {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            return EU_TIMEZONES.includes(timezone);
        }

        if (!isFromEu()) {
            document.querySelector('#eu').classList.add('hidden')
        }

        const internal = location.host.replace("www.", "")
        const a = document.getElementsByTagName('a')

        for (let i = 0; i < a.length; i++) {
            if (!a[i].href.includes(internal) || a[i].href.includes('/documentation')) {
                a[i].setAttribute('target', '_blank')
            }
        }
    </script>
@endsection
