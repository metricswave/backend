@extends('layouts.landing')

@section('content')
    <div class="mw-landing p-app mx-auto mt-20 mb-12">
        <div class="flex flex-col space-y-6 text-lg leading-loose">
            <h3 class="text-2xl">Hi 👋,</h3>
            <p>Welcome to the {{ config('app.name') }} launch list. We are currently working to launch the product as
                soon as possible.</p>
            <p>Meanwhile, you can help us in various ways:</p>

            <div class="pb-16 sm:pb-22">
                @include('lead.partials.todo')
            </div>

            <hr class="opacity-10"/>

            <div class="flex flex-col space-y-6 pt-12 sm:pt-20">
                <h2 class="scroll-mt-10 text-2xl font-bold dark:text-white"
                    id="lifetime-license">Lifetime license ✨</h2>
                <p><span class="underline">This is a unique opportunity.</span> In the future, when we launch
                    {{ config('app.name') }}, there will be two plans, a free plan and a monthly payment plan.</p>
                <p>The free plan will have a maximum number of notifications and some triggers will be available only to
                    paid users.</p>
                <p>But if you are on this list, you can purchase a lifetime license. This means that you will have
                    access to all features and unlimited notifications for life.</p>
                <p>And the best part is that you will get this license for a very low price.</p>
            </div>
        </div>
    </div>

    {{--    <PriceSection lead="{lead}"--}}
@endsection
