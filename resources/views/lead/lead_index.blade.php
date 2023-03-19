@extends('layouts.landing')

@section('content')
    @if(request()->query('success'))
        <div class="mw-landing mt-20 mb-10 mx-auto">
            <div class="p-4 rounded bg-green-50 dark:bg-green-500/10">
                <p><strong>Thanks for purchasing a lifetime license 🥰.</strong> In the coming days, we will publish a
                    roadmap to see when the first version will be available and what it will contain. Just one more
                    thing, <a
                        class="text-blue-500 hover:underline"
                        href="https://twitter.com/intent/tweet?text=Just%20got%20my%20lifetime%20license%20for%20v{{ config('app.name') }}!%0A%0ALooking%20forward%20to%20launching%20the%20app%20to%20set%20up%20my%20own%20notifications.%0A%{{ config('app.url') }}"
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

            <div class="flex flex-col space-y-6 pt-12 sm:pt-20">
                <h2 class="scroll-mt-10 text-2xl font-bold dark:text-white"
                    id="lifetime-license">Lifetime license ✨</h2>
                <p><span class="underline">This is a unique opportunity.</span> In the future, when we launch
                    {{ config('app.name') }}, there will be two plans, a free plan and a monthly payment plan.</p>
                <p>The free plan will have a maximum number of notifications and some triggers will be available only to
                    paid users.</p>
                <p>But if you are on this list, you can purchase a lifetime license. This means that you will have
                    access to all features and unlimited notifications for life.</p>
                <p>And the best part is that you will get this license for a very low price.</p>
            </div>
        </div>
    </div>

    @if ($lead->paid_price === 0)
        <div class="relative">
            <!-- Animated bubbles in background -->
            <div class="absolute top-2 left-10 h-48 w-48 animate-blob rounded-full bg-pink-500/30 blur-3xl"></div>
            <div class="absolute top-64 left-0 h-48 w-48 animate-blob rounded-full bg-cyan-500/30 blur-3xl"></div>
            <div class="absolute top-12 right-0 h-48 w-48 animate-blob rounded-full bg-blue-500/30 blur-3xl"></div>
            <div class="absolute top-24 right-12 h-48 w-48 animate-blob rounded-full bg-pink-500/30 blur-3xl"></div>

            <div class="mw-landing mx-auto mb-10">
                <p class="mt-2 text-center leading-normal leading-loose opacity-70">
                    Limited offer, get early access on a lifetime deal.<br/>
                    <span class="font-bold">Single one-time payment.</span>
                </p>
            </div>

            <div class="mw-landing mx-auto flex flex-col space-y-6 sm:flex-row sm:space-y-0 sm:space-x-6">
                @foreach($prices as $price)
                    <a
                        href="{{ $price->remaining === 0 ? '' : '/leads/' . $lead->uuid . '/prices/' . $price->id }}"
                        class="backdrop-blur-x duration-400 flex-1 rounded border bg-white/50 p-6 transition-all  dark:border-zinc-600 dark:bg-zinc-700/50 dark:shadow-zinc-400 {{ $price->remaining > 0 ? 'shadow hover:bg-white/90 dark:hover:bg-zinc-700' : 'cursor-default opacity-90' }}">

                        <h3 class="mt-3 flex flex-row items-center justify-center text-center text-6xl font-light">
                            <span class="text-3xl opacity-90">$</span>
                            <span>{{ explode(',', number_format($price->price/100, 2, ',', '.'))[0] }}</span>
                            <span class="-ml-1 text-3xl opacity-80">.{{ explode(',', number_format($price->price/100, 2, ',', '.'))[1] }}</span>
                        </h3>

                        <p class="mt-3 text-center text-xs leading-relaxed {{ $price->remaining === 0 ? 'text-red-500' : '' }} {{ $price->remaining > 0 && $price->remaining < 7 ? 'text-yellow-500' : '' }}">
                            {{ $price->remaining }} of {{ $price->total_available }} remain<br/>at this price
                        </p>

                        <div class="mt-6 w-full text-center">
                            @if($price->remaining <= 0)
                                <div
                                    class="duration-400 mx-auto block cursor-default rounded border bg-white/30 py-4 text-center backdrop-blur-none transition-all dark:border-zinc-50/50 dark:bg-white/10 dark:shadow-zinc-500/50">
                                    Buy it now
                                </div>
                            @else
                                <div
                                    class="duration-400 mx-auto block rounded border bg-white/30 py-4 text-center shadow backdrop-blur-none transition-all hover:bg-white/75 active:bg-white/100 active:shadow-none dark:border-zinc-50/50 dark:bg-white/10 dark:shadow-zinc-500/50 hover:dark:border-zinc-50/90 dark:hover:bg-white/25 hover:dark:shadow-zinc-500/10 active:dark:bg-white/40 active:dark:shadow-none">
                                    Buy it now
                                </div>
                            @endif
                        </div>

                    </a>
                @endforeach
            </div>

            <div class="mw-landing mx-auto pt-20 text-sm opacity-75">
                <ul class="list-outside list-disc space-y-3 px-10">
                    <li>You will have all the functionalities forever without any limitation.</li>
                    <li>We guarantee that the final price will be higher. This is a great one-time offer.</li>
                    <li>In the case that, {{ config('app.name') }} is not released during this year. All the money will
                        be returned
                        automatically. No need to request it.
                    </li>
                    <li>If you have any question, just <a class="underline"
                                                          href="mailto:{{ config('app.mailto') }}">mail us</a>.
                    </li>
                </ul>
            </div>
        </div>
    @endif
@endsection
