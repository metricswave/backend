@extends('layouts.landing')

@section('content')
    <div class="flex flex-col items-center justify-center space-y-14 sm:space-y-32">
        <div class="mw-landing mx-auto my-10 flex flex-col space-y-8 sm:my-40">
            <h1 class="animate-[out_1s,_fade-in-down_1.5s_ease-out_1s] text-3xl sm:text-6xl leading-[1.3] sm:leading-[1.1] tracking-tighter">
                <span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">Notifications</span>
                <br/>for everything that matters to you
            </h1>

            <p class="animate-[out_1.25s,_fade-in-down_1.5s_ease-out_1.25s] text-lg font-light leading-normal sm:text-2xl">
                &mdash; from your favorites sport events,
                reminders to leave for appointments, the latest news updates, bank transactions, severe weather alerts,
                or anything else.
            </p>

            <p class="animate-[out_1.5s,_fade-in-down_1.5s_ease-out_1.5s] text-lg font-light leading-normal sm:text-2xl">
                Never miss a beat and stay on top of your
                game.</p>

            <div class="animate-[out_1.75s,_fade-in-down_1.5s_ease-out_1.75s] ">
                @include('landing.lead-form')
            </div>

            @if(Date::createFromFormat('Y-m-d', '2023-05-03')->isFuture())
                <a href="/blog/on-may-3rd-we-will-open-the-beta-to-the-first-users"
                   class="animate-[out_2s,_fade-in-down_1.5s_ease-out_2s] w-full flex items-center rounded-full block bg-yellow-50 dark:bg-yellow-500/10 py-3 px-5">
                    <div class="mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor"
                             width="20px"
                             height="20px"
                             viewBox="0 0 32 32"
                             version="1.1">
                            <path d="M18 23l-1-0v-8.938c0-0.011-0.003-0.021-0.003-0.031s0.003-0.020 0.003-0.031c0-0.552-0.448-1-1-1h-2c-0.552 0-1 0.448-1 1s0.448 1 1 1h1v8h-1c-0.552 0-1 0.448-1 1s0.448 1 1 1h4c0.552 0 1-0.448 1-1s-0.448-1-1-1zM16 11c1.105 0 2-0.896 2-2s-0.895-2-2-2-2 0.896-2 2 0.896 2 2 2zM16-0c-8.836 0-16 7.163-16 16s7.163 16 16 16c8.837 0 16-7.163 16-16s-7.163-16-16-16zM16 30.031c-7.72 0-14-6.312-14-14.032s6.28-14 14-14 14 6.28 14 14-6.28 14.032-14 14.032z"/>
                        </svg>
                    </div>

                    <div>
                        <span>First beta access on May 3rd.</span>
                        <span class="text-blue-500 underline hover:no-underline smooth">Read more →</span>
                    </div>
                </a>
            @endif
        </div>

        <div class="animate-[out_2.25s,_fade-in-down_1.5s_ease-out_2.25s] relative w-full">
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
