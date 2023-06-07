@extends('layouts.landing')

@section('meta')
@endsection

@section('content')
    <div class="flex flex-col items-center justify-center space-y-14 sm:space-y-16">
        <div class="mx-auto flex flex-col space-y-8 mt-20 mb-8 sm:mt-40 sm:mb-8 max-w-[750px]">
            <h1 class="animate-[out_1s,_fade-in-down_1.5s_ease-out_1s] text-4xl sm:text-6xl text-center leading-tight sm:leading-tight tracking-tighter">
                Real-time monitoring for your
                <span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">website or apps</span>
            </h1>

            <p class="md:px-10 animate-[out_1.25s,_fade-in-down_1.5s_ease-out_1.25s] text-center text-xl sm:text-2xl leading-normal sm:leading-normal opacity-70 sm:pb-0">
                Track every inch of your product, monitor potential issues or opportunities, and respond by making
                data-driven decisions.
            </p>

            @if(config('feature.sign_up_leads_only'))
                @include('landing.lead-form')
            @else
                <a class="animate-[out_1.75s,_fade-in-down_1.5s_ease-out_1.75s] py-4 px-6 text-center bg-gradient-to-b from-slate-800 via-black to-black hover:bg-gradient-to-b hover:from-slate-600 hover:via-slate-900 hover:to-black text-white block mx-auto rounded-lg shadow-lg hover:shadow smooth"
                   href="{{ config('app.web_app_url') }}?utm_source=calendar_ttl_landing">Start tracking my business</a>
            @endif
        </div>

        <div class="animate-[out_2.5s,_fade-in-down_1.5s_ease-out_2.5s] mw-landing flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <div>
                <img src="/images/landings/monitoring.png"
                     class="dark:border dark:border-zinc-800 rounded mt-3 max-w-full w-auto"
                     title="Business realtime monitoring">
            </div>
        </div>

        <div class="max-w-[600px] flex flex-col py-12 sm:py-24 md:py-36">
            <div class="flex flex-col space-y-3"
                 style="padding-bottom: 6rem">
                <h2 class="text-xl sm:text-2xl leading-tight sm:leading-tight tracking-tighter font-bold">
                    Realtime analytics for each event of your business.
                </h2>
                <p>
                    You can track every event of your business, from a user registration to a payment, and even a
                    customer support ticket.
                </p>
                <p>
                    And you can also see, in real-time, analytics for each event, like the number of events per day,
                    the number of events per user, or the number of events per country.
                </p>
            </div>

            <div class="flex flex-col space-y-3"
                 style="padding-bottom: 6rem">
                <h2 class="text-xl sm:text-2xl leading-tight sm:leading-tight tracking-tighter font-bold">
                    Track each event of your business with a simple line of code.
                </h2>
                <p>
                    Sending and event is as simple as calling an endpoint. You can send events from your backend or
                    frontend, and even from your mobile apps.
                </p>
                <p class="pt-2">
                    → <a class="text-blue-500 underline hover:no-underline smooth"
                         target="_blank"
                         href="/documentation/triggers/webhooks">How to trigger an event?</a>
                </p>
            </div>

            <div class="flex flex-col space-y-3">
                <h2 class="text-xl sm:text-2xl leading-tight sm:leading-tight tracking-tighter font-bold">
                    Send your events to Telegram or Slack.
                </h2>
                <p>
                    You can connect your Telegram or Slacks channel and receive your events in real-time.
                </p>
                <p class="pt-2">
                    → <a class="text-blue-500 underline hover:no-underline smooth"
                         target="_blank"
                         href="/documentation/services/telegram">How to connect a Telegram channel?</a>
                </p>
            </div>
        </div>

    </div>


    <div class="mw-landing m-auto my-20 flex flex-col sm:items-center justify-center space-y-4 sm:space-y-8 sm:my-40">
        <h2 class="mb-0 text-xl sm:mb-2 sm:text-3xl font-bold">Haven't you signed up yet?</h2>
        <p class="sm:text-center mb-2 sm:mb-16 max-w-[600px]">
            Leave us your email, and we will notify you of all progress. You can also help us <strong>define the future
                of {{ config('app.name') }}</strong> and even get a lifetime license at a single price.
        </p>
        @include('landing.lead-form')
    </div>
@endsection
