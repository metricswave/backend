<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <meta content="Real-time notifications for everything that matters to you."
          name="description"/>

    {{-- Favicon --}}
    <link rel="apple-touch-icon"
          sizes="57x57"
          href="/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon"
          sizes="60x60"
          href="/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon"
          sizes="72x72"
          href="/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon"
          sizes="76x76"
          href="/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon"
          sizes="114x114"
          href="/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon"
          sizes="120x120"
          href="/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon"
          sizes="144x144"
          href="/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon"
          sizes="152x152"
          href="/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon"
          sizes="180x180"
          href="/images/favicon/apple-icon-180x180.png">
    <link rel="icon"
          type="image/png"
          sizes="192x192"
          href="/images/favicon/android-icon-192x192.png">
    <link rel="icon"
          type="image/png"
          sizes="32x32"
          href="/images/favicon/favicon-32x32.png">
    <link rel="icon"
          type="image/png"
          sizes="96x96"
          href="/images/favicon/favicon-96x96.png">
    <link rel="icon"
          type="image/png"
          sizes="16x16"
          href="/images/favicon/favicon-16x16.png">
    <link rel="manifest"
          href="/images/favicon/manifest.json">

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
            <li><a href="/privacy-policy">Privacy Policy</a></li>
            <li><a href="/terms-and-conditions">Terms of Service</a></li>
        </ul>
    </footer>
</body>
</html>
