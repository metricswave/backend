@extends('layouts.landing')

@section('content')
    <div class="flex flex-col items-center justify-center space-y-14 sm:space-y-32">
        <div class="mw-landing px-app mx-auto my-10 flex flex-col space-y-8 sm:my-40">
            <h1 class="animate-[out_1s,_fade-in-down_1.5s_ease-out_1s] text-3xl sm:text-6xl leading-[1.3] sm:leading-[1.1] tracking-tighter">
                Real-time
                <span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">analytics</span>
                <br/>for your product
            </h1>

            <p class="animate-[out_1.25s,_fade-in-down_1.5s_ease-out_1.25s] text-lg font-light leading-normal sm:text-2xl">
                Track every use-case of your business in real-time, know what your users are doing, and monitor
                potential issues easily.
            </p>

            <div class="animate-[out_1.75s,_fade-in-down_1.5s_ease-out_1.75s] ">
                @if(config('feature.sign_up_leads_only'))
                    @include('landing.lead-form')
                @else
                    <div class="flex flex-col sm:flex-row items-center justify-start gap-6">
                        <a
                            class="py-4 px-6 text-center bg-gradient-to-b from-slate-800 via-black to-black dark:from-zinc-800 dark:via-zinc-800 dark:to-zinc-800 hover:bg-gradient-to-b hover:from-slate-600 hover:via-slate-900 hover:to-black hover:dark:from-zinc-700 hover:dark:via-zinc-700 hover:dark:to-zinc-700 text-white block ml-0 rounded-lg shadow-lg hover:shadow smooth linkToApp w-full sm:w-auto"
                            href="{{ config('app.web_app_url') }}"
                        >
                            {{ $buttonText ?? 'Start Tracking my Product →' }}
                        </a>

                        <a
                            class="py-4 px-6 opacity-60 hover:opacity-100 smooth border rounded-lg w-full sm:w-auto text-center"
                            href="https://app.metricswave.com/fUwWlrz6Xhedh12/metricswave.com"
                            target="_blank"
                        >
                            Live Demo
                        </a>
                    </div>
                @endif

                <div class="text-center sm:text-left pt-10">
                    <div class="opacity-70 smooth mb-6 sm:mb-12 mx-auto inline-block bg-gradient-to-r from-yellow-200 to-yellow-200 dark:from-yellow-800 dark:to-yellow-800 bg-no-repeat [background-position:0_88%] hover:opacity-75 [background-size:100%_0.2em] motion-safe:transition-all motion-safe:duration-200 hover:[background-size:100%_100%] focus:[background-size:100%_100%]">
                        +500 companies are trusting us!
                    </div>
                </div>
            </div>

        </div>

        <div id="eu"
             class="animate-[out_2.25s,_fade-in-down_1.5s_ease-out_2.25s] relative w-full border-b soft-border px-app">
            <div class="mw-landing mx-auto mb-32">
                <h2 class="text-3xl">No cookies, fully compliant with GDPR, CCPA and PECR.</h2>
                <p class="text-lg pt-5 max-w-[568px]">
                    We don't use cookies, we don't store any personal data, and we don't track your users across
                    websites.
                </p>
                <p class="pt-5">
                    Made and hosted in the EU 🇪🇺.
                </p>
            </div>
        </div>

        <div class="animate-[out_2.25s,_fade-in-down_1.5s_ease-out_2.25s] relative w-full border-b soft-border px-app">
            <div class="mw-landing mx-auto mb-16">
                <h2 class="text-3xl">Measure your Traffic.</h2>
                <p class="text-lg pt-5 max-w-[568px]">
                    Start registering all your traffic and referrals to get basic insights about how people are
                    using
                    your product.
                </p>
            </div>

            <div class="">
                <img class="max-w-full mx-auto dark:hidden"
                     src="/images/landings/track_visits_light.png"/>
                <img class="max-w-full mx-auto hidden dark:block"
                     src="/images/landings/track_visits_dark.png"/>
            </div>
        </div>

        <div class="animate-[out_2.25s,_fade-in-down_1.5s_ease-out_2.25s] relative w-full border-b soft-border px-app">
            <div class="mw-landing mx-auto mb-16">
                <h2 class="text-3xl">Watch every important event<br/>in Real-time.</h2>
                <p class="text-lg pt-5 max-w-[568px]">
                    Track every important event in your product, receive notifications, and monitor potential
                    issues.
                </p>
            </div>

            <div class="">
                <img class="max-w-full mx-auto dark:hidden"
                     src="/images/landings/event_history_light.png"/>
                <img class="max-w-full mx-auto hidden dark:block"
                     src="/images/landings/event_history_dark.png"/>
            </div>
        </div>

        <div class="animate-[out_2.25s,_fade-in-down_1.5s_ease-out_2.25s] relative w-full border-b soft-border px-app">
            <div class="mw-landing mx-auto mb-16">
                <h2 class="text-3xl">Not just traffic.</h2>
                <p class="text-lg pt-5 max-w-[568px]">
                    You can track any event in your product, from a user signing up, to a payment, or a user
                    clicking a button and get stats about it.
                </p>
            </div>

            <div class="">
                <img class="max-w-full mx-auto dark:hidden"
                     src="/images/landings/event_stats_light.png"/>
                <img class="max-w-full mx-auto hidden dark:block"
                     src="/images/landings/event_stats_dark.png"/>
            </div>
        </div>

        <div class="animate-[out_2.25s,_fade-in-down_1.5s_ease-out_2.25s] relative w-full border-b soft-border px-app">
            <div class="mw-landing mx-auto mb-32">
                <h2 class="text-3xl">Easy to Integrate</h2>
                <p class="text-lg pt-5 max-w-[568px]">
                    You can integrate it in minutes, just copy and paste a few lines of code, and you're ready to
                    go.
                </p>
                <p class="pt-5">
                    <a
                        class="text-blue-500 hover:text-blue-600 underline smooth"
                        href="/documentation"
                        target="_blank">
                        Explore our docs →
                    </a>
                </p>
            </div>
        </div>

    </div>

    <div class="mw-landing m-auto my-20 flex flex-col sm:flex-row items-center justify-between space-y-8 sm:space-y-0 sm:space-x-8 sm:my-40">
        <div class="text-center sm:text-left">
            <h2 class="text-2xl sm:text-3xl pb-4">Start for
                <span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">free</span>
                today.</h2>
            <h3 class="text-lg sm:text-xl">Measure and analyze your traffic.</h3>
        </div>

        @include('partials.sign-up-button', [
            'buttonText' => 'Create Your Account →',
        ])
    </div>
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
    </script>
@endsection
