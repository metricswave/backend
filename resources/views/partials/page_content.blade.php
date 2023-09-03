{{-- w-10 dark:text-orange-500 h-auto animate-[out_1.5s,_fade-in-down_2s_ease-out_1s] animate-[out_2s,_fade-in-down_2.5s_ease-out_1s] animate-[out_2.5s,_fade-in-down_3s_ease-out_1s] animate-[out_3s,_fade-in-down_3.5s_ease-out_1s] --}}
<div class="flex flex-col gap-16 md:gap-32 mt-16 md:mt-32">
    @foreach($structured_content as $i => $content)
        @php
            $out =  min(3, 1.5 + ($i * 0.5));
            $fade = $out + 0.5;
            $hasImage = strlen($content['image']) > 0 && strlen($content['dark_image']) > 0;
            $hasVideo = $hasImage && Str::of($content['image'])->contains('mp4');
        @endphp

        @if($content['type'] === 'features')
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
                            <div class="-ml-1">{!! $grid['icon'] !!}</div>
                            <h3 class="font-bold text-lg">{{ $grid['title'] }}</h3>
                            {!! $grid['content'] !!}
                        </div>
                    @endforeach
                </div>
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
                            <source src="{{ $content['image'] }}"
                                    type="video/mp4">
                        </video>
                        <video autoplay
                               loop
                               muted
                               playsinline
                               class="max-w-full mx-auto hidden dark:block">
                            <source src="{{ $content['dark_image'] }}"
                                    type="video/mp4">
                        </video>
                    </div>
                @elseif($hasImage)
                    <div class="max-w-4xl mx-auto">
                        <img src="{{ $content['image'] }}"
                             alt="{{ $content['title'] }}"
                             class="max-w-full mx-auto dark:hidden"/>
                        <img src="{{ $content['dark_image'] }}"
                             alt="{{ $content['title'] }}"
                             class="max-w-full mx-auto hidden dark:block"/>
                    </div>
                @endif
            </section>
        @elseif($content['type'] === 'comparison')
            <section class="mw-landing px-app mx-auto w-full animate-[out_{{$out}}s,_fade-in-down_{{ $fade }}s_ease-out_1s] flex flex-col gap-10 sm:gap-12">
                @foreach($content['characteristic'] as $c)
                    <div class="flex flex-col gap-2">
                        <div class="-ml-1">{!! $c['icon'] !!}</div>
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
