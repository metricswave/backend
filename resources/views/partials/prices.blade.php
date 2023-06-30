@php
    use App\Services\Plans\PlanGetter;
    $withoutTitle = $withoutTitle ?? false;
@endphp

<div class="relative">
    <div class="absolute bottom-2 left-10 h-48 w-48 animate-blob rounded-full bg-pink-500/30 blur-3xl"></div>
    <div class="absolute top-64 left-0 h-48 w-48 animate-blob rounded-full bg-cyan-500/30 blur-3xl"></div>
    <div class="absolute bottom-12 right-10 h-48 w-48 animate-blob rounded-full bg-blue-500/30 blur-3xl"></div>
    <div class="absolute top-24 right-36 h-48 w-48 animate-blob rounded-full bg-pink-500/30 blur-3xl"></div>

    <div class="p-app mt-12 {{!$withoutTitle ? 'sm:mt-44' : ''}} mw-landing mx-auto">
        @if (!$withoutTitle)
            <h2 class="text-2xl md:text-4xl sm:text-center font-bold mb-6 leading-snug mx-auto">
                Secure your <br class="hidden md:inline-block"/>lifetime license deal
            </h2>
            <div class="sm:text-center opacity-50 pb-6 flex flex-col space-y-3 md:px-10 mb-8 max-w-[700px] mx-auto">
                <p>Get your deal at a discounted rate. You will receive an invitation immediately.</p>
            </div>
        @endif

        <div class="mw-landing mx-auto flex flex-col gap-4 md:flex-row">
            @foreach(app(PlanGetter::class)->all() as $plan)
                @if ($plan->id->value === 4)
                    @continue
                @endif

                <a
                    href="https://app.metricswave.com?utm_source=metricswave&utm_medium=landing_prices&utm_campaign=pricing&utm_term=price_{{$plan->id->value}}"
                    class="backdrop-blur-x duration-400 flex-grow flex-1 rounded border bg-white/50 p-6 transition-all dark:border-zinc-600 dark:bg-zinc-700/50 dark:shadow-zinc-400 shadow hover:bg-white/90 dark:hover:bg-zinc-700">

                    <h2 class="text-center mb-4 opacity-60">
                        {{ $plan->name }} Plan
                    </h2>

                    <h3 class="mt-3 flex flex-row items-center justify-center text-center text-6xl font-light">
                        <span class="text-3xl opacity-90">$</span>
                        <span>{{ explode(',', number_format($plan->monthlyPrice/100, 2, ',', '.'))[0] }}</span>
                        <span class="-ml-1 text-3xl opacity-80">.{{ explode(',', number_format($plan->monthlyPrice/100, 2, ',', '.'))[1] }}/mo</span>
                    </h3>

                    <ul class="flex flex-col gap-2 pt-6 pb-2 text-xs opacity-70 text-center">
                        <li>All features available.</li>
                        <li>Cancel at any time.</li>
                        <li>{{ $plan->eventsLimit !== null ? number_format($plan->eventsLimit) : 'Unlimited' }}
                            events per month.
                        </li>
                        <li>{{ $plan->dataRetentionInMonths ?? 'Unlimited' }} months retention.</li>
                        <li>Early bird price.</li>
                    </ul>

                    <div class="mt-6 w-full text-center">
                        <div
                            class="duration-400 mx-auto block rounded border bg-white/30 py-4 text-center shadow backdrop-blur-none transition-all hover:bg-white/75 active:bg-white/100 active:shadow-none dark:border-zinc-50/50 dark:bg-white/10 dark:shadow-zinc-500/50 hover:dark:border-zinc-50/90 dark:hover:bg-white/25 hover:dark:shadow-zinc-500/10 active:dark:bg-white/40 active:dark:shadow-none">
                            {{ $plan->id->value === 1 ? "Create Account" : "Subscribe Now" }}
                        </div>
                    </div>

                </a>
            @endforeach
        </div>

        <div>
            <p class="text-center opacity-80 pt-10 text-sm">
                Need more? <a href="mailto:sales@metricswave.com"
                              class="text-blue-500 dark:hover:text-blue-200 hover:text-blue-800 transition-all duration-300">Contact
                    us</a> for a custom plan.
            </p>
        </div>

    </div>
</div>
