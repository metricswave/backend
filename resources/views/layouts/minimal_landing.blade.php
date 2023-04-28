<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <meta content="Real-time notifications for everything that matters to you."
          name="description"/>

    @include('partials.meta')
    @include('partials.favicon')

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.analytics')
</head>
<body>
    <div class="max-w-[400px] m-auto h-screen my-20 flex flex-col space-y-4 sm:space-y-4 sm:my-40">
        <nav class="flex mb-10">
            <a class="flex items-center space-x-3 text-zinc-900 dark:text-white"
               href="/">
                <div class="inline-block h-6 w-6 bg-gradient-to-b from-pink-500 to-amber-500"></div>
                <span class="font-bold tracking-tighter">{{ config('app.name') }}</span>
            </a>
        </nav>

        @yield('content')
    </div>
</body>
</html>
