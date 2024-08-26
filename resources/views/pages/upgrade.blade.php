@extends('layouts.landing', ['minimal' => true])

@section('meta')
    <title>Upgrade your account - {{ config('app.name') }}</title>
    <meta
        content="Upgrade your plan account on MetricsWave and access all the features of this privacy-friendly analytics tool"
        name="description"
    />

    {{-- OG Tags --}}
    <meta property="og:url"
          content="{{ safe_url(config('app.url').request()->getPathInfo()) }}" />
    <meta property="og:locale"
          content="en_US" />
    <meta property="og:type"
          content="article" />
    <meta property="og:title"
          content="Upgrade your account - {{ config('app.name') }}" />
    <meta property="og:description"
          content="Upgrade your plan account on MetricsWave and access all the features of this privacy-friendly analytics tool" />
    @if (isset($og_image))
        <meta property="og:image"
              content="{{ $og_image }}" />
    @else
        <meta property="og:image"
              content="{{ safe_url(config('app.url').'/images/metricswave.png?v=20230612161011') }}" />
    @endif

    <meta name="twitter:card"
          content="summary_large_image" />
    <meta name="twitter:title"
          content="Upgrade your account - {{ config('app.name') }}" />
    <meta name="twitter:description"
          content="Upgrade your plan account on MetricsWave and access all the features of this privacy-friendly analytics tool" />
    @if (isset($og_image))
        <meta name="twitter:image"
              content="{{ $og_image }}" />
    @else
        <meta name="twitter:image"
              content="{{ safe_url(config('app.url').'/images/metricswave.png?v=20230612161011') }}" />
    @endif
@endsection

@section('content')
    <div class="pt-14 sm:pt-40 flex flex-col justify-start gap-10">
        <section class="mx-auto mw-landing px-app animate-[out_1s,_fade-in-down_1.5s_ease-out_1s] w-full">
            <h1 class="text-4xl sm:text-5xl leading-[1.3] sm:leading-[1.2] tracking-tighter">
                {{ __("Upgrade your account") }}
            </h1>

            <div class="prose dark:prose-invert prose-lg mt-5">
                {!! __("You are about to upgrade your :domain account to enjoy all the benefits of statistics while respecting privacy and without cookies.", ['domain' => "<code>{$team->domain}</code>"]) !!}
            </div>
        </section>

        <section class="mx-auto mw-landing px-app animate-[out_1.5s,_fade-in-down_2s_ease-out_1.5s] w-full">
            <livewire:upgrade-form team-id="{{ $team->id }}" />
        </section>
    </div>
@endsection

@section('head_scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
