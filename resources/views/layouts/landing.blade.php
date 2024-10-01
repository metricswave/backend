@php($minimal ??= false)
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @hasSection('meta')
        @yield('meta')
    @else
        @include('partials.meta')
    @endif

    @include('partials.favicon')

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.analytics')

    @yield('head_scripts')
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NT7M9TVS" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <nav class="flex justify-between items-center px-4 pt-8 pb-8 mx-auto sm:px-8">
        @if (!$minimal)
            <a class="flex items-center space-x-3 dark:text-white text-zinc-900" href="/">
                <div class="inline-block w-6 h-6 bg-gradient-to-b from-pink-500 to-amber-500"></div>
                <span class="font-bold tracking-tighter">{{ config('app.name') }}</span>
            </a>
        @else
            <div class="flex items-center space-x-3 dark:text-white text-zinc-900">
                <div class="inline-block w-6 h-6 bg-gradient-to-b from-pink-500 to-amber-500"></div>
                <span class="font-bold tracking-tighter">{{ config('app.name') }}</span>
            </div>
        @endif

        @if (!$minimal)
            @include('partials.nav')
        @endif
    </nav>

    <div>
        @yield('content')
    </div>

    @if (!$minimal)
        @include('partials.footer')
    @else
        <div class="h-48"></div>
    @endif

    @yield('scripts')
</body>

</html>
