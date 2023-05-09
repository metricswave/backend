@php use App\Services\Prices\GetLandingPricesService; @endphp

<div class="relative">
    <div class="absolute bottom-2 left-10 h-48 w-48 animate-blob rounded-full bg-pink-500/30 blur-3xl"></div>
    <div class="absolute top-64 left-0 h-48 w-48 animate-blob rounded-full bg-cyan-500/30 blur-3xl"></div>
    <div class="absolute bottom-12 right-10 h-48 w-48 animate-blob rounded-full bg-blue-500/30 blur-3xl"></div>
    <div class="absolute top-24 right-36 h-48 w-48 animate-blob rounded-full bg-pink-500/30 blur-3xl"></div>

    <div class="p-app mt-12 sm:mt-44 mw-landing mx-auto">
        <h2 class="text-4xl sm:text-center font-bold mb-6">Get your lifetime license deal</h2>
        <div class="sm:text-center opacity-50 pb-6">
            We are currently selling lifetime licenses at a discounted price while working on the first version
            of {{ config('app.name') }}. Get yours now!
        </div>

        <div class="sm:text-center">
            <div class="opacity-70 smooth mb-6 sm:mb-12 mx-auto inline-block bg-gradient-to-r from-yellow-200 to-yellow-200 bg-no-repeat [background-position:0_88%] hover:opacity-75 [background-size:100%_0.2em] motion-safe:transition-all motion-safe:duration-200 hover:[background-size:100%_100%] focus:[background-size:100%_100%]">
                +200 users are trusting us!
            </div>
        </div>

        <div class="mw-landing mx-auto flex flex-col space-y-6 sm:flex-row sm:space-y-0 sm:space-x-6">
            @foreach(app(GetLandingPricesService::class)() as $price)
                <a
                    href="{{ $price->remaining === 0 ? '' : '/leads/create/prices/' . $price->id . '?utm_source=notifywave&utm_medium=referral&utm_campaign=pricing' }}"
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
    </div>
</div>
