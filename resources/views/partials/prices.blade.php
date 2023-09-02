@php
    use App\Services\Plans\PlanGetter;
    $withoutTitle = $withoutTitle ?? false;
@endphp

@if(config('landing.show_prices', false))
    <livewire:prices :without-title="$withoutTitle"/>
@else
    <div class="mw-landing m-auto my-20 flex flex-col sm:flex-row items-center justify-between space-y-8 sm:space-y-0 sm:space-x-8 sm:my-40 px-app">
        <div class="text-center sm:text-left">
            <h2 class="text-2xl sm:text-3xl pb-4">Get started for
                <span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">free</span>.
            </h2>
            <h3 class="text-lg sm:text-xl">Track, analyze and optimize traffic.</h3>
        </div>

        @include('partials.sign-up-button', [
            'buttonText' => 'Create Your Account →',
        ])
    </div>
@endif
