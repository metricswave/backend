@extends('layouts.landing')

@section('content')
    @if(request()->query('success'))
        <div class="mw-landing mt-20 mb-10 mx-auto">
            <div class="p-4 rounded bg-green-50 dark:bg-green-500/10">
                <p><strong>Thanks for purchasing a lifetime license 🥰.</strong> Just one more thing, <a
                        class="text-blue-500 hover:underline"
                        href="https://twitter.com/intent/tweet?text=Just%20got%20my%20lifetime%20license%20for%20{{ config('app.name') }}!%0A%0ALooking%20forward%20to%20launching%20the%20app%20to%20set%20up%20my%20own%20notifications.&url={{ config('app.url') }}"
                        rel="noreferrer"
                        target="_blank">Share your purchase!</a></p>

            </div>
        </div>
    @endif

    <div class="mw-landing p-app mx-auto mt-20">
        <div class="flex flex-col space-y-6 text-lg leading-loose">
            <h3 class="text-2xl">Hi 👋,</h3>
            <p>Welcome to the {{ config('app.name') }} launch list. We are currently working to launch the product as
                soon as possible.</p>
            <p>Meanwhile, you can help us in various ways:</p>

            <div class="pb-16 sm:pb-22">
                @include('lead.partials.todo')
            </div>

            <div class="mt-12 px-5 py-4 shadow-sm text-base rounded bg-yellow-50 dark:bg-yellow-500/10">
                <p>🗺️ &mdash; We want to be transparent with the timing and development of our app. Here you have all
                    the information about how it will be and when the first version will be released.
                    <a class="font-bold underline underline-offset-4 hover:no-underline"
                       href="/roadmap">Check our roadmap →</a></p>
            </div>

            <div class="flex flex-col space-y-6 pt-12 sm:pt-20">
                <h2 class="scroll-mt-10 text-2xl font-bold dark:text-white"
                    id="lifetime-license">Lifetime license ✨</h2>
                <p><span class="font-bold">This is a unique opportunity.</span> In the future, when we launch
                    {{ config('app.name') }}, there will be two plans, a free plan and a monthly payment plan.</p>
                <p>The free plan will have a maximum number of notifications and some triggers will be available only to
                    paid users.</p>
                <p>But if you are on this list, you can purchase a lifetime license. This means that you will have
                    access to all features and unlimited notifications for life.</p>
                <p>And the best part is that you will get this license for a very low price.</p>
            </div>
        </div>
    </div>

    @include('partials.prices', ['withoutTitle' => true])
@endsection
