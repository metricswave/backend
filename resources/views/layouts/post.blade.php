<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ safe_url(config('app.url') . request()->getPathInfo()) }}" />

    @yield('meta')
    @include('partials.favicon')

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.analytics')
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NT7M9TVS" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <nav class="flex justify-between items-center mx-auto mt-8 p-app mw-landing">
        <a class="flex items-center space-x-3 dark:text-white text-zinc-900" href="/">
            <div class="inline-block w-6 h-6 bg-gradient-to-b from-pink-500 to-amber-500"></div>
            <span class="font-bold tracking-tighter">{{ config('app.name') }}</span>
        </a>

        <ul class="flex space-x-4"></ul>
    </nav>

    <div class="p-app">
        @yield('content')
    </div>

    @include('partials.prices')

    @include('partials.footer')

    @yield('scripts')
</body>

</html>
