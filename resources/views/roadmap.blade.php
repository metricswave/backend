@extends('layouts.landing')

@section('content')
    <div class="flex flex-col items-center justify-center space-y-14 sm:space-y-16">
        <div class="mw-landing mx-auto flex flex-col space-y-8 sm:mt-40 sm:mb-8">
            <h1 class="text-4xl sm:text-5xl leading-tight tracking-tighter">The
                <span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">Roadmap</span>
            </h1>

            <p class="text-xl font-light leading-normal">Thanks to the initial support, the number of
                accounts and licenses sold, {{ config('app.name') }} is currently in development.</p>
            <p class="text-xl font-light leading-normal">We want to be transparent, right from the start,
                and that is why we have prepared this roadmap, which we will update frequently.</p>
            <p class="text-xl font-light leading-normal">Here you will be able to see the initial features
                that the first version of {{ config('app.name') }} will have and the estimated release time.</p>
        </div>

        <div class="mw-landing mx-auto">
            <p class="text-lg">Based on the results of the survey and the feedback we have received, these are the
                features and release date of the first version.</p>
        </div>

        <div class="relative w-full">
            <ol class="mw-landing relative mx-auto border-zinc-200 dark:border-zinc-700 sm:border-l">
                <li class="ml-14 pb-10">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span>1</span></div>

                    <h3 class="mb-3 text-xl font-bold">🌍 Web Application</h3>
                    <p class="pb-4 text-lg font-light leading-normal">
                        This is basic. A web application where you can manage and create notifications and see a history
                        of all the notifications you have received.
                    </p>
                    <p class="pb-4 text-lg font-light leading-normal">
                        You will also have basic options to change your password, delete your account, get help. The
                        usual stuff.
                    </p>
                </li>

                <li class="ml-14 pb-10">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span>2</span></div>

                    <h3 class="mb-3 text-xl font-bold">📱 Android and iOS application</h3>
                    <p class="pb-4 text-lg font-light leading-normal">
                        As on the website, you will be able to create and control your notifications, but it will also
                        help us to send you notifications in real time whenever you want.
                    </p>
                </li>

                <li class="ml-14 pb-44">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span>3</span></div>

                    <h3 class="mb-3 text-xl font-bold">🗓️ Google Calendar trigger</h3>
                    <p class="pb-4 text-lg font-light leading-normal">This has been the most voted trigger in our
                        poll.</p>
                    <p class="pb-4 text-lg font-light leading-normal">You will be able to connect your Google Calendar
                        account and receive notifications every time you are invited to an event, at the time of the
                        event and when you leave in case the event has a specific location.</p>
                    <p class="pb-4 text-lg font-light leading-normal">All this with filters and so you can avoid those
                        notifications that do not interest you.</p>
                </li>
            </ol>

            <div class="-mt-44 mb-4 overflow-x-scroll px-20 pt-4 pb-10">
                <div class="relative flex w-[3300px] space-x-10 after:content-[''] ml-48">
                    <div class="w-[450px]">
                        <div class="group relative w-full">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-100 to-cyan-200 animate-tilt rounded-xl opacity-10 blur transition duration-[2s] group-hover:opacity-50 group-hover:duration-300"></div>
                            <div class="rounded-xl bg-white/80 p-5 backdrop-blur-xl dark:bg-black/60 flex items-center space-x-4">
                                <img alt="Calendar"
                                     class="h-16 w-16 rounded-2xl"
                                     src="/images/triggers/calendar.png">
                                <div class="flex flex-col items-start justify-between">
                                    <div class="font-bold">Calendar</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Next meetings, no invites,
                                        birthdays,
                                        or anything else.
                                    </div>
                                </div>
                                <div class="w-14 text-zinc-500 opacity-60 transition-all duration-500 group-hover:opacity-90 dark:text-zinc-50">
                                    <svg class=""
                                         fill="currentColor"
                                         version="1.1"
                                         viewBox="-102.4 -102.4 1228.80 1228.80"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier"
                                           stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier"
                                           stroke-linecap="round"
                                           stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M256 120.768L306.432 64 768 512l-461.568 448L256 903.232 659.072 512z"
                                                  fill="currentColor"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-[450px]">
                        <div class="group relative w-full">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-200 to-purple-400 animate-tilt rounded-xl opacity-10 blur transition duration-[2s] group-hover:opacity-50 group-hover:duration-300"></div>
                            <div class="rounded-xl bg-white/80 p-5 backdrop-blur-xl dark:bg-black/60 flex items-center space-x-4">
                                <img alt="Transit notifications"
                                     class="h-16 w-16 rounded-2xl"
                                     src="/images/triggers/live_transit.png">
                                <div class="flex flex-col items-start justify-between">
                                    <div class="font-bold">Transit notifications</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Time to leave, time to arrive,
                                        schedule changes, and more.
                                    </div>
                                </div>
                                <div class="w-14 text-zinc-500 opacity-60 transition-all duration-500 group-hover:opacity-90 dark:text-zinc-50">
                                    <svg class=""
                                         fill="currentColor"
                                         version="1.1"
                                         viewBox="-102.4 -102.4 1228.80 1228.80"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier"
                                           stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier"
                                           stroke-linecap="round"
                                           stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M256 120.768L306.432 64 768 512l-461.568 448L256 903.232 659.072 512z"
                                                  fill="currentColor"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ol class="mw-landing relative mx-auto border-zinc-200 dark:border-zinc-700 sm:border-l">
                <li class="ml-14 pb-44">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span>4</span></div>

                    <h3 class="mb-3 text-xl font-bold">💅 Custom trigger</h3>
                    <p class="pb-4 text-lg font-light leading-normal">You will be able to
                        integrate {{ config('app.name') }} with
                        other applications or scripts easily.</p>
                    <p class="pb-4 text-lg font-light leading-normal">You will receive a URL from which you can send
                        notifications to yourself instantly. This way you can easily integrate it into almost any
                        site.</p>
                    <p class="pb-4 text-lg font-light leading-normal">You will also be able to create notifications to
                        be triggered at a certain frequency, time, day of the week, etc.</p>
                </li>
            </ol>

            <div class="-mt-44 mb-4 overflow-x-scroll px-20 pt-4 pb-10">
                <div class="relative flex w-[3300px] space-x-10 after:content-[''] ml-48">
                    <div class="w-[450px]">
                        <div class="group relative w-full">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-red-100 to-purple-200 animate-tilt rounded-xl opacity-10 blur transition duration-[2s] group-hover:opacity-50 group-hover:duration-300"></div>
                            <div class="rounded-xl bg-white/80 p-5 backdrop-blur-xl dark:bg-black/60 flex items-center space-x-4">
                                <img alt="On time notifications"
                                     class="h-16 w-16 rounded-2xl"
                                     src="/images/triggers/on_time.png">
                                <div class="flex flex-col items-start justify-between">
                                    <div class="font-bold">On time notifications</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Set reminders or notification
                                        to be
                                        delivered just on time.
                                    </div>
                                </div>
                                <div class="w-14 text-zinc-500 opacity-60 transition-all duration-500 group-hover:opacity-90 dark:text-zinc-50">
                                    <svg class=""
                                         fill="currentColor"
                                         version="1.1"
                                         viewBox="-102.4 -102.4 1228.80 1228.80"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier"
                                           stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier"
                                           stroke-linecap="round"
                                           stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M256 120.768L306.432 64 768 512l-461.568 448L256 903.232 659.072 512z"
                                                  fill="currentColor"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-[450px]">
                        <div class="group relative w-full">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-red-100 to-pink-400 animate-tilt rounded-xl opacity-10 blur transition duration-[2s] group-hover:opacity-50 group-hover:duration-300"></div>
                            <div class="rounded-xl bg-white/80 p-5 backdrop-blur-xl dark:bg-black/60 flex items-center space-x-4">
                                <img alt="Medication"
                                     class="h-16 w-16 rounded-2xl"
                                     src="/images/triggers/medication.png">
                                <div class="flex flex-col items-start justify-between">
                                    <div class="font-bold">Medication</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Track your medication and get
                                        reminders on time.
                                    </div>
                                </div>
                                <div class="w-14 text-zinc-500 opacity-60 transition-all duration-500 group-hover:opacity-90 dark:text-zinc-50">
                                    <svg class=""
                                         fill="currentColor"
                                         version="1.1"
                                         viewBox="-102.4 -102.4 1228.80 1228.80"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier"
                                           stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier"
                                           stroke-linecap="round"
                                           stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M256 120.768L306.432 64 768 512l-461.568 448L256 903.232 659.072 512z"
                                                  fill="currentColor"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-[450px]">
                        <div class="group relative w-full">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-100 to-blue-400 animate-tilt rounded-xl opacity-10 blur transition duration-[2s] group-hover:opacity-50 group-hover:duration-300"></div>
                            <div class="rounded-xl bg-white/80 p-5 backdrop-blur-xl dark:bg-black/60 flex items-center space-x-4">
                                <img alt="Webhook"
                                     class="h-16 w-16 rounded-2xl"
                                     src="/images/triggers/webhook.png">
                                <div class="flex flex-col items-start justify-between">
                                    <div class="font-bold">Webhook</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">A simple way to integrate
                                        {{ config('app.name') }} with any other tool.
                                    </div>
                                </div>
                                <div class="w-14 text-zinc-500 opacity-60 transition-all duration-500 group-hover:opacity-90 dark:text-zinc-50">
                                    <svg class=""
                                         fill="currentColor"
                                         version="1.1"
                                         viewBox="-102.4 -102.4 1228.80 1228.80"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier"
                                           stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier"
                                           stroke-linecap="round"
                                           stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M256 120.768L306.432 64 768 512l-461.568 448L256 903.232 659.072 512z"
                                                  fill="currentColor"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <ol class="mw-landing relative mx-auto border-zinc-200 dark:border-zinc-700 sm:border-l">
                <li class="ml-14 pb-10">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span>5</span></div>

                    <h3 class="mb-3 text-xl font-bold">🎉 First public release &mdash; <em>Jun 2023</em></h3>
                    <p class="pb-4 text-lg font-light leading-normal">We are now ready to launch the first version.</p>
                    <p class="pb-4 text-lg font-light leading-normal">This will help us get up and running, make sure
                        everything is working properly, make sure the notifications are sent at the right time, but this
                        is just the beginning.</p>
                </li>

                <li class="ml-14 pb-10">
                    <div
                        class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900 sm:-left-4"
                    ><span class="text-lg">&infin;</span></div>

                    <h3 class="mb-3 text-xl font-bold">And more trigger…</h3>
                    <p class="pb-4 text-lg font-light leading-normal">This will be followed by tracking of shipments,
                        news, bank transactions, sporting events and more.</p>
                </li>
            </ol>
        </div>
    </div>

    <div class="mw-landing m-auto my-20 flex flex-col items-center justify-center space-y-8 sm:my-40">
        <h2 class="mb-1 text-2xl sm:mb-2 sm:text-3xl">Haven't you signed up yet?</h2>
        <p class="text-center mb-8 sm:mb-16 max-w-[600px]">
            Leave us your email, and we will notify you of all progress. You can also help us <strong>define the future
                of {{ config('app.name') }}</strong> and even get a lifetime license at a single price.
        </p>
        @include('landing.lead-form')
    </div>
@endsection
