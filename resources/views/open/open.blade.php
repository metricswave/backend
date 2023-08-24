@extends('layouts.landing')

@section('content')
    <div class="p-app mx-auto mw-landing py-16 sm:py-24">
        <h1 class="text-4xl sm:text-center font-bold mb-6">Open Metrics</h1>
        <div class="sm:text-center opacity-50 pb-12">
            Here you can find all the metrics about {{ config('app.name') }}.
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 mt-10 mb-24 sm:mb-0">
            <div class="flex flex-col space-y-3 p-6 border dark:border-zinc-600 rounded-sm w-full aspect-square items-center justify-center">
                <div class="text-6xl"
                     id="weekly">{{ $notifications['weekly'] }}</div>
                <div class="text-center">Current Week Events</div>
            </div>

            <div class="flex flex-col space-y-3 p-6 border dark:border-zinc-600 rounded-sm w-full aspect-square items-center justify-center">
                <div class="text-6xl"
                     id="monthly">{{ $notifications['monthly'] }}</div>
                <div class="text-center">Current Month Events</div>
            </div>

            <div class="flex flex-col space-y-3 p-6 border dark:border-zinc-600 rounded-sm w-full aspect-square items-center justify-center">
                <div class="text-6xl"
                     id="yearly">{{ $notifications['yearly'] }}</div>
                <div class="text-center">Current Year Events</div>
            </div>
        </div>

        @include('partials.prices')
    </div>
@endsection

@section('scripts')
    <script>
        countUp = async function (elementId, target) {
            let current = parseInt(document.getElementById(elementId).innerHTML);
            while (target !== current) {
                if (target > current) {
                    current++;
                } else {
                    current--;
                }
                document.getElementById(elementId).innerHTML = current;

                await new Promise((resolve) => {
                    setTimeout(() => {
                        resolve(true)
                    }, 5)
                });
            }
        }

        setInterval(function () {
            fetch('/api/open')
                .then(response => response.json())
                .then(data => {
                    const notifications = data.data.notifications
                    countUp('weekly', (notifications.weekly * 2));
                    countUp('monthly', (notifications.monthly * 2));
                    countUp('yearly', (notifications.yearly * 2));
                });
        }, 1500);
    </script>
@endsection
