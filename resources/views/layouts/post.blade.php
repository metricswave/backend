@php use App\Services\Prices\GetLandingPricesService; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    @yield('meta')
    @include('partials.favicon')

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.analytics')
</head>
<body>
    <nav class="p-app mw-landing mx-auto mt-8 flex items-center justify-between">
        <a class="flex items-center space-x-3 text-zinc-900 dark:text-white"
           href="/">
            <div class="inline-block h-6 w-6 bg-gradient-to-b from-pink-500 to-amber-500"></div>
            <span class="font-bold tracking-tighter">{{ config('app.name') }}</span>
        </a>

        <ul class="flex space-x-4">
            <li><a href="/blog">Blog</a></li>
        </ul>
    </nav>

    <div class="p-app">
        @yield('content')
    </div>

    <div class="pt-12 sm:pt-44 mw-landing mx-auto">
        <h2 class="text-4xl sm:text-center font-bold mb-6">Get your lifetime license deal</h2>
        <div class="sm:text-center opacity-50 pb-6 sm:pb-12">
            We are currently selling lifetime licenses at a discounted price while working on the first version
            of {{ config('app.name') }}. Get yours now!
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

    <footer class="mt-16 flex items-start justify-between px-10 pb-10 sm:mt-32 sm:items-center md:mt-64">
        <ul>
            <li class="flex">
                <a class="flex items-center space-x-3 text-zinc-900 dark:text-white"
                   href="/">
                    <span class="font-bold tracking-tighter">{{ config('app.name') }} {{ now()->year }}™</span>
                </a>
            </li>
        </ul>

        <ul class="flex flex-col space-y-4 tracking-tighter sm:flex-row sm:space-x-8 sm:space-y-0">
            <li><a href="/open">Open Metrics</a></li>
            <li><a href="/privacy-policy">Privacy Policy</a></li>
            <li><a href="/terms-and-conditions">Terms of Service</a></li>
        </ul>
    </footer>
</body>
</html>
