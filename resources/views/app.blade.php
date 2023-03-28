<!doctype html>
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

    <!-- CSRF Token -->
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('partials.analytics')
</head>
<body>
    <div id="app"></div>
</body>
</html>
