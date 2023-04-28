@extends('layouts.landing')

@section('meta')
@endsection

@section('content')
    <div class="flex flex-col items-center justify-center space-y-14 sm:space-y-16">
        <div class="mx-auto flex flex-col space-y-8 mt-20 mb-8 sm:mt-40 sm:mb-8 max-w-[750px]">
            <h1 class="text-4xl sm:text-6xl text-center leading-tight sm:leading-tight tracking-tighter">
                Notifications<br/>from your
                <span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">terminal</span>
            </h1>

            <p class="text-center text-xl sm:text-2xl leading-tight sm:leading-tight opacity-70 sm:pb-6">
                Execute a long command and receive a notification on all your devices when it is finished.
            </p>

            @if(config('feature.sign_up_leads_only'))
                <a class="py-4 px-6 text-center bg-gradient-to-b from-zinc-800 dark:from-zinc-700 via-black dark:via-zinc-800 to-black dark:to-zinc-800 hover:bg-gradient-to-b hover:from-zinc-700 hover:via-zinc-900 hover:to-black text-white block mx-auto rounded-lg shadow-lg hover:shadow smooth"
                   href="/leads">Create your notification</a>
            @else
                <a class="py-4 px-6 text-center bg-gradient-to-b from-slate-800 via-black to-black hover:bg-gradient-to-b hover:from-slate-600 hover:via-slate-900 hover:to-black text-white block mx-auto rounded-lg shadow-lg hover:shadow smooth"
                   href="{{ config('app.app_url') }}">Create your notification</a>
            @endif
        </div>

        <div class="mw-landing flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <div>
                <video class="w-full rounded-[10px] shadow-xl"
                       autoplay
                       muted
                       loop>
                    <source src="/videos/terminal_notification.mp4"
                            type="video/mp4">
                </video>
            </div>
            <div>
                <video class="w-full rounded-[10px] shadow-xl"
                       autoplay
                       muted
                       loop>
                    <source src="/videos/telegram_terminal_notification.mp4"
                            type="video/mp4">
                </video>
            </div>
        </div>


        <div class="mw-wide-landing flex flex-col-reverse sm:flex-row items-center justify-center sm:space-y-0 sm:space-x-10 py-12 sm:py-24 md:py-36">
            <div class="flex flex-col space-y-2">
                <h2 class="text-xl sm:text-2xl leading-tight sm:leading-tight tracking-tighter font-bold">
                    Your terminal just got better
                </h2>
                <p>
                    Send yourself a notification at any time from the terminal and to as many devices or channels as you
                    want. It's as simple as running a command.
                </p>
                <p>→ <a class="text-blue-500 underline hover:no-underline smooth"
                        href="/documentation/notifywave-in-your-terminal">How to trigger a notification from your
                        terminal</a></p>
            </div>

            <img src="/images/landings/terminal_notification.png"
                 class="pb-10 sm:pb-0"
                 alt="Terminal notification">
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
