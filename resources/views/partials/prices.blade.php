@php
    use App\Services\Prices\GetLandingPricesService;use App\Transfers\PriceType;
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
                <p>Get lifetime licenses or monthly subscriptions at <br class="hidden md:inline-block"/>a discounted
                    rate. Prices set to increase soon.</p>
                <p class="font-bold">Users who buy any of them will receive an
                    <br class="hidden md:inline-block"/>invitation immediately.</p>
            </div>
        @endif

        <div class="mw-landing mx-auto flex flex-col space-y-6 sm:flex-row sm:space-y-0 sm:space-x-6">
            @foreach(app(GetLandingPricesService::class)() as $price)
                <a
                    href="{{ $price->remaining === 0 ? '' : '/leads/create/prices/' . $price->id . '?utm_source=notifywave&utm_medium=referral&utm_campaign=pricing' }}"
                    class="backdrop-blur-x duration-400 flex-1 rounded border bg-white/50 p-6 transition-all  dark:border-zinc-600 dark:bg-zinc-700/50 dark:shadow-zinc-400 {{ $price->remaining > 0 ? 'shadow hover:bg-white/90 dark:hover:bg-zinc-700' : 'cursor-default opacity-90' }}">

                    <h2 class="text-center mb-4 opacity-60">
                        {{ $price->type === PriceType::Lifetime ? 'Lifetime License' : ''}}
                        {{ $price->type === PriceType::Monthly ? 'Monthly Subscription' : ''}}
                    </h2>

                    <h3 class="mt-3 flex flex-row items-center justify-center text-center text-6xl font-light">
                        <span class="text-3xl opacity-90">$</span>
                        <span>{{ explode(',', number_format($price->price/100, 2, ',', '.'))[0] }}</span>
                        <span class="-ml-1 text-3xl opacity-80">.{{ explode(',', number_format($price->price/100, 2, ',', '.'))[1] }}</span>
                    </h3>

                    @php
                        $percentage = $price->remaining / $price->total_available;
                        $color = match (true) {
                            $percentage < 0.5 && $percentage > 0.25 => 'text-yellow-500',
                            $percentage < 0.25 => 'text-red-500',
                            default => ''
                        }
                    @endphp

                    <p class="mt-2 opacity-80 text-center text-xs leading-relaxed {{$color}}">
                        {{ $price->remaining }} of {{ $price->total_available }} remaining.
                    </p>

                    <p class="mt-0 opacity-80 text-center text-xs leading-relaxed {{ $color }}">
                        Price increasing by <strong>30%</strong>
                    </p>

                    <ul class="flex flex-col space-y-1 pt-6 pb-2 text-xs opacity-70 text-center">
                        <li>All features available.</li>
                        <li>
                            {{ $price->type === PriceType::Lifetime ? 'One single payment.' : 'Cancel at any time.' }}
                        </li>
                        <li>Best price available.</li>
                    </ul>

                    <div class="mt-6 w-full text-center">
                        @if($price->remaining <= 0)
                            <div
                                class="duration-400 mx-auto block cursor-default rounded border bg-white/30 py-4 text-center backdrop-blur-none transition-all dark:border-zinc-50/50 dark:bg-white/10 dark:shadow-zinc-500/50">
                                Buy it now
                            </div>
                        @else
                            <div
                                class="duration-400 mx-auto block rounded border bg-white/30 py-4 text-center shadow backdrop-blur-none transition-all hover:bg-white/75 active:bg-white/100 active:shadow-none dark:border-zinc-50/50 dark:bg-white/10 dark:shadow-zinc-500/50 hover:dark:border-zinc-50/90 dark:hover:bg-white/25 hover:dark:shadow-zinc-500/10 active:dark:bg-white/40 active:dark:shadow-none">
                                {{ $price->type === PriceType::Lifetime ? 'Buy it Now' : 'Subscribe Now'}}
                            </div>
                        @endif
                    </div>

                </a>
            @endforeach
        </div>
    </div>
</div>
