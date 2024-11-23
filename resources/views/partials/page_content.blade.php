{{-- w-10 dark:text-orange-500 h-auto animate-[out_1.5s,_fade-in-down_2s_ease-out_1s] animate-[out_2s,_fade-in-down_2.5s_ease-out_1s] animate-[out_2.5s,_fade-in-down_3s_ease-out_1s] animate-[out_3s,_fade-in-down_3.5s_ease-out_1s] --}}
<div class="flex flex-col gap-16 md:gap-32 mt-16 md:mt-32">
    @foreach($structured_content as $i => $content)
        @php
            $out =  min(3, 1.5 + ($i * 0.5));
            $fade = $out + 0.5;
            $hasImage = isset($content['image']) && strlen($content['image']['url']) > 0 && strlen($content['dark_image']['url']) > 0;
            $hasVideo = $hasImage && Str::of($content['image']['url'])->contains('mp4');
        @endphp

        @if($content['type'] === 'open_numbers')
            <section class="mx-auto w-full soft-border border-b animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s] overflow-hidden">
                <div class="mw-landing mx-auto px-app">
                    <h2 class="text-2xl sm:text-3xl font-medium mb-4 text-balance mx-auto text-center !leading-snug max-w-[30ch]">
                        {{ $content['title'] }}
                    </h2>

                    <div class="text-center prose dark:prose-invert mx-auto text-pretty">
                        @if(Str::of($content['content'])->length() > 0)
                            {!! $content['content'] !!}
                        @endif
                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-10 mt-10 -mb-2 bg-white dark:bg-zinc-800/60 rounded-sm border border-zinc-400/20 dark:border-zinc-800 shadow">
                        <div class="flex flex-col space-y-3 px-6 py-12 md:py-24 rounded-sm w-full items-center justify-center">
                            <div class="text-5xl" id="monthly">0000</div>
                            <div class="text-center">{{ app()->getLocale() === 'es' ? 'Mes actual' : 'Current Month Events' }}</div>
                        </div>

                        <div class="flex flex-col space-y-3 px-6 py-12 md:py-24 rounded-sm w-full items-center justify-center">
                            <div class="text-5xl" id="yearly">0000</div>
                            <div class="text-center">{{ app()->getLocale() === 'es' ? 'Año actual' : 'Current Year Events' }}</div>
                        </div>
                    </div>
                </div>
            </section>
        @elseif($content['type'] === 'features')
            <section class="mx-auto mw-landing px-app animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s]">
                @if (Str::of($content['title'])->length() > 0)
                    <h2 class="text-2xl sm:text-3xl font-medium mb-4 !leading-snug max-w-[30ch]">
                        {{ $content['title'] }}
                    </h2>
                @endif

                @if(Str::of($content['short_description'])->length() > 0)
                    {!! $content['short_description'] !!}
                @endif

                <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-x-8 md:gap-y-10">
                    @foreach($content['grid'] as $grid)
                        <div class="flex flex-col gap-2">
                            <div class="-ml-1">{!! $grid['icon']['value'] !!}</div>
                            <h3 class="font-bold text-lg">{{ $grid['title'] }}</h3>
                            {!! $grid['content'] !!}
                        </div>
                    @endforeach
                </div>

                @if (isset($content['button']['show_buttons']) && $content['button']['show_buttons'] === true)
                    <div class="flex flex-col sm:flex-row items-center justify-start gap-6 animate-[out_1.75s,_fade-in-down_1.5s_ease-out_1.75s] mt-6 sm:mt-12">
                        <a
                            class="py-4 px-6 text-center bg-gradient-to-b from-slate-800 via-black to-black dark:from-zinc-800 dark:via-zinc-800 dark:to-zinc-800 hover:bg-gradient-to-b hover:from-slate-600 hover:via-slate-900 hover:to-black hover:dark:from-zinc-700 hover:dark:via-zinc-700 hover:dark:to-zinc-700 text-white block ml-0 rounded-lg shadow-lg hover:shadow smooth linkToApp w-full sm:w-auto"
                            href="{{ config('app.web_app_url') }}"
                        >
                            {!!
                              $content['button']['main_button_text'] ??
                              'Start Tracking <span class="hidden md:inline">my Product </span>for Free →'
                            !!}
                        </a>
                    </div>
                @endif
            </section>
        @elseif($content['type'] === 'section')
            <section class="mx-auto mw-landing px-app prose dark:prose-invert animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s]">
                <h2 class="text-2xl sm:text-3xl font-medium mb-4 !leading-snug">{{ $content['title'] }}</h2>
                {!! $content['content'] !!}
            </section>
        @elseif($content['type'] === 'section_with_image')
            <section class="mx-auto w-full soft-border border-b animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s] overflow-hidden">
                <div class="mw-landing mx-auto px-app {{ !$hasImage ? 'mb-16 md:mb-32' : 'mb-8 md:mb-16' }}">
                    <h2 class="text-2xl sm:text-3xl font-medium mb-4 !leading-snug max-w-[30ch]">
                        {{ $content['title'] }}
                    </h2>
                    <div class="prose md:prose-lg dark:prose-invert">
                        {!! $content['content'] !!}
                    </div>
                </div>

                @if ($hasVideo)
                    <div class="max-w-4xl mx-auto -mb-0.5">
                        <video autoplay
                               loop
                               muted
                               playsinline
                               class="max-w-full mx-auto dark:hidden">
                            <source src="{{ $content['image']['url'] }}"
                                    type="video/mp4">
                        </video>
                        <video autoplay
                               loop
                               muted
                               playsinline
                               class="max-w-full mx-auto hidden dark:block">
                            <source src="{{ $content['dark_image']['url'] }}"
                                    type="video/mp4">
                        </video>
                    </div>
                @elseif($hasImage)
                    <div class="max-w-4xl mx-auto">
                        <img src="{{ $content['image']['url'] }}"
                             alt="{{ $content['title'] }}"
                             class="max-w-full mx-auto dark:hidden"/>
                        <img src="{{ $content['dark_image']['url'] }}"
                             alt="{{ $content['title'] }}"
                             class="max-w-full mx-auto hidden dark:block"/>
                    </div>
                @endif
            </section>
        @elseif($content['type'] === 'comparison')
            <section class="mw-landing px-app mx-auto w-full animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s] flex flex-col gap-10 sm:gap-12">
                @foreach($content['characteristic'] as $c)
                    <div class="flex flex-col gap-2">
                        <div class="-ml-1">{!! $c['icon']['value'] !!}</div>
                        <h3 class="text-xl sm:text-2xl font-medium mb-4 !leading-snug max-w-[30ch]">
                            {{ $c['characteristic'] }}
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="prose prose-sm dark:prose-invert">
                                <h4>{{ config('app.name') }}</h4>
                                {!! $c['us'] !!}
                            </div>

                            <div class="prose prose-sm dark:prose-invert">
                                <h4>{{ $content['competitor'] }}</h4>
                                {!! $c['competitor'] !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
        @endif
    @endforeach
</div>

@section('scripts')
    <script>
        const fetchOpenData = () => {
            if (document.getElementById('monthly') == null) {
                return
            }

            fetch('/api/open')
                .then(response => response.json())
                .then(data => {
                    const notifications = data.data.notifications
                    document.getElementById('monthly').innerHTML = notifications.monthly
                    document.getElementById('yearly').innerHTML = notifications.yearly
                });
        }

        fetchOpenData()
        setInterval(fetchOpenData, 10_000);
    </script>
@endsection
