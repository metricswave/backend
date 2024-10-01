<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <meta content="Real-time notifications for everything that matters to you." name="description" />

    @include('partials.meta')
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

    <div class="flex flex-col m-auto my-20 space-y-4 h-screen sm:my-40 sm:space-y-4 max-w-[400px]">
        <nav class="flex mb-10">
            <a class="flex items-center space-x-3 dark:text-white text-zinc-900" href="/">
                <div class="inline-block w-6 h-6 bg-gradient-to-b from-pink-500 to-amber-500"></div>
                <span class="font-bold tracking-tighter">{{ config('app.name') }}</span>
            </a>
        </nav>

        @yield('content')
    </div>
</body>

</html>
