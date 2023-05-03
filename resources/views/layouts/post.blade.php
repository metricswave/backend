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

        <ul class="flex space-x-4"></ul>
    </nav>

    <div class="p-app">
        @yield('content')
    </div>

    @include('partials.prices')

    @include('partials.footer')
</body>
</html>
