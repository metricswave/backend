@extends('layouts.landing')

@section('content')
    <div class="flex flex-col items-center justify-center space-y-14 sm:space-y-32">
        <div class="mw-landing mx-auto my-20 flex flex-col space-y-8 sm:my-40">
            <h1 class="text-4xl sm:text-5xl leading-tight tracking-tighter">Real-time
                <br><span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-4xl text-transparent after:absolute after:-right-9 after:top-0 after:inline-block after:h-5 after:w-5 after:animate-ping after:rounded-full after:bg-gradient-to-b after:from-pink-500 after:to-amber-500 after:content-[''] sm:text-6xl">notifications</span><br>
                for everything that matters to you</h1>

            <p class="text-xl font-light leading-normal sm:text-2xl">&mdash; from your favorites sport events,
                reminders to leave for appointments, the latest news updates, bank transactions, severe weather alerts,
                or anything else.</p>

            <p class="text-xl font-light leading-normal sm:text-2xl">Never miss a beat and stay on top of your
                game.</p>
            @include('landing.lead-form')
        </div>

        <div class="relative w-full">
            <h2 class="mw-landing mx-auto mb-16 text-3xl">How it works</h2>

            <ol class="mw-landing relative mx-auto border-zinc-200 pb-[580px] dark:border-zinc-700 sm:border-l">
                <li class="ml-14">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span>1</span></div>

                    <h3 class="mb-3 text-xl font-bold">Choose a trigger</h3>
                    <p class="pr-10 text-lg font-light leading-normal">
                        You can choose from a wide range of triggers. Connect your calendar, chooser your favorite
                        sports teams, your location, connect with your bank, or create a custom one. The
                        possibilities are endless.
                    </p>
                </li>
            </ol>

            @include('landing.trigger-list')

            <ol class="mw-landing relative mx-auto border-zinc-200 dark:border-zinc-700 sm:border-l">
                <li class="mb-16 ml-14">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span>2</span></div>

                    <h3 class="mb-3 text-xl font-bold">Customize your notification</h3>
                    <p class="text-lg font-light leading-normal">
                        You can customize the notification to your liking. You can choose to be notified by email,
                        push, or Telegram. You can also apply some filters to avoid being notified about everything.
                    </p>

                    @include('landing.configure-notifications')
                </li>

                <li class="mb-16 ml-14">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span>3</span></div>

                    <h3 class="mb-3 text-xl font-bold">Relax, you're on top of it</h3>
                    <p class="text-lg font-light leading-normal">
                        You'll be notified when something happens. You can also check the notifications history to
                        see what you missed.
                    </p>
                </li>
            </ol>
        </div>
    </div>

    <div class="mw-landing m-auto my-20 flex flex-col items-center justify-center space-y-8 sm:my-40">
        <h2 class="mb-4 text-2xl sm:mb-10 sm:text-3xl">Get notified when we launch</h2>
        @include('landing.lead-form')
    </div>
@endsection
