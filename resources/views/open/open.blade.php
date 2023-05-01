@extends('layouts.landing')

@section('content')
    <div class="mx-auto mw-landing py-16 sm:py-24">
        <h1 class="text-4xl sm:text-center font-bold mb-6">Open Metrics</h1>
        <div class="sm:text-center opacity-50 pb-12">
            Here you can find all the metrics about {{ config('app.name') }}.
        </div>

        <div class="flex flex-col sm:flex-row space-y-10 sm:space-x-10 sm:space-y-0">
            <div class="flex flex-col space-y-3 p-6 border dark:border-zinc-600 rounded-sm w-full aspect-square items-center justify-center">
                <div class="text-6xl">{{ $leadsCount }}</div>
                <div>Users</div>
            </div>

            <div class="flex flex-col space-y-3 p-6 border dark:border-zinc-600 rounded-sm w-full aspect-square items-center justify-center">
                <div class="text-6xl flex flex-row items-center">
                    <span class="text-3xl mr-0.5">$</span>{{
                         explode('.', number_format($income/100, 2))[0]
                    }}<span class="text-4xl tracking-tighter">.{{
                        explode('.', number_format($income/100, 2))[1]
                    }}</span>
                </div>
                <div>Income</div>
            </div>
        </div>

        @include('partials.prices')
    </div>
@endsection
