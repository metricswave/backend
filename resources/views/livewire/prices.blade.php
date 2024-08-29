@php
    use App\Services\Plans\PlanGetter;
    $withoutTitle = $withoutTitle ?? false;
@endphp

<div class="relative scroll-mt-10 sm:scroll-mt-16"
     id="pricing">
    <div class="absolute bottom-2 left-10 h-48 w-48 animate-blob rounded-full bg-pink-500/30 blur-3xl"></div>
    <div class="absolute top-64 left-0 h-48 w-48 animate-blob rounded-full bg-cyan-500/30 blur-3xl"></div>
    <div class="absolute bottom-12 right-10 h-48 w-48 animate-blob rounded-full bg-blue-500/30 blur-3xl"></div>
    <div class="absolute top-24 right-36 h-48 w-48 animate-blob rounded-full bg-pink-500/30 blur-3xl"></div>

    <div class="p-app mt-12 {{!$withoutTitle ? 'sm:mt-44' : ''}} mw-landing mx-auto">
        @if (!$withoutTitle)
            <h2 class="text-2xl md:text-4xl sm:text-center font-bold mb-6 leading-snug mx-auto">
                {!! __('Choose the plan<br/>that fits your needs') !!}
            </h2>
            <div class="sm:text-center text-zinc-500 pb-6 flex flex-col space-y-3 md:px-10 mb-8 max-w-[700px] mx-auto">
                <p>
                    <a href="https://app.metricswave.com"
                       class="border-b border-dotted border-blue-500 text-blue-500 smooth hover:text-blue-700 dark:hover:text-blue-300 hover:border-solid">{{ __("Start for free") }}</a>, {{ __("and upgrade your account at any moment") }}.
                </p>
            </div>
        @endif

        <div class="mw-wide-landing mx-auto flex flex-col sm:flex-row items-start gap-10 mb-14">
            <div class="w-full sm:w-7/12 flex flex-col gap-4">
                @foreach(app(PlanGetter::class)->all() as $plan)
                    @php
                        $formattedLimit = format_long_numbers($plan->eventsLimit, 0);
                        $link = match ($plan->name) {
                            'Free' => 'https://app.metricswave.com',
                            'Enterprise' => 'mailto:hi@metricswave.com',
                            default => 'https://app.metricswave.com?utm_source=metricswave&utm_medium=landing_prices&utm_campaign=pricing&utm_term=price_'.$plan->id->value,
                        }
                    @endphp

                    <a
                        href="{{ $link }}"
                        class="backdrop-blur-x duration-400 flex-grow flex-1 rounded-lg border bg-white/50 transition-all dark:border-zinc-600 dark:bg-zinc-700/50 dark:shadow-zinc-900 shadow hover:bg-white/90 dark:hover:bg-zinc-700 flex flex-row items-center justify-between gap-6 p-5">

                        <h3 class="flex flex-row items-center justify-center text-center text-2xl font-light">
                            @if ($plan->name === 'Free')
                                <span class="text-base opacity-90">{{ __("Free") }}</span>
                            @elseif($plan->name === 'Enterprise')
                                <span class="text-base opacity-90">{{ __("Contact us") }}</span>
                            @else
                                <span class="text-base opacity-90">$</span>
                                <span>{{ explode(',', number_format($plan->monthlyPrice/100, 2, ',', '.'))[0] }}</span>
                                <span class="text-base -ml-0.5 opacity-80">.{{ explode(',', number_format($plan->monthlyPrice/100, 2, ',', '.'))[1] }}/{{ __("mo") }}</span>
                            @endif
                        </h3>

                        <div class="flex flex-col gap-2 text-xs opacity-70 text-center">
                            @if($plan->name === "Enterprise")
                                {{ __("Unlimited traffic") }}
                            @else
                                {{ $plan->eventsLimit !== null ? $formattedLimit : 'Unlimited' }} {{ __("visits per month") }}.
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pl-4 sm:pl-0">
                <h3 class="font-semibold mb-4">{{ __("All plans include") }}:</h3>

                <ul class="list-disc list-inside text-sm flex flex-col gap-2">
                    <li>{{ __("100% data ownership") }}</li>
                    <li>{{ __("Forever data retention") }}</li>
                    <li>{{ __("No cookie banner required") }}</li>
                    <li>{{ __("GDPR law compliance") }}</li>
                    <li>{{ __("Unlimited support") }}</li>
                    <li>{{ __("Cancel at any time") }}</li>
                    <li>{{ __("All features available") }}</li>
                </ul>
            </div>
        </div>

    </div>
</div>
