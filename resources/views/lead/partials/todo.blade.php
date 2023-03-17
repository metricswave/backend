<ul class="leading-tight -mt-4">
    @foreach($todos as $todo)
        <li>
            <a
                class="items-top group flex cursor-pointer flex-row rounded p-5 transition-all duration-300 hover:animate-none {{ $todo['done'] === false ? "hover:bg-blue-50/75 active:bg-blue-100/50 dark:hover:bg-blue-800/5 dark:active:bg-blue-500/50 bg-red-500/5 mt-4" : "opacity-70 hover:opacity-100" }}"
                href="{{ $todo['link'] }}">

                <!-- Circle -->
                <div class="">
                    <div
                        class="mr-6 flex h-6 w-6 items-center justify-center rounded-full border-gray-400 dark:border-gray-600 border-2 text-white no-underline transition-all duration-300 group-hover:bg-white/10 {{ $todo['done'] === false ? "bg-zinc-500/10" : 'animate-pulse bg-zinc-500/5' }}">
                        @if($todo['done'])
                            <div class="rotate-45 text-black dark:text-zinc-100">+</div>
                        @endif
                    </div>
                </div>

                <!-- Title and description -->
                <div class="{{ $todo['done'] ? 'line-through' : '' }}">
                    {{ $todo['text'] }}
                    @if($todo['description'] !== null)
                        <br/><span class="text-sm opacity-70">{{ $todo['description'] }}</span>
                    @endif
                </div>
            </a>
        </li>
    @endforeach
    <li>
        <a
            class="items-top group flex cursor-pointer flex-row rounded p-5 transition-all duration-300 hover:animate-none hover:bg-blue-50/75 active:bg-blue-100/50 dark:hover:bg-blue-800/5 dark:active:bg-blue-500/50 bg-red-500/5 mt-4"
            href="https://twitter.com/intent/tweet?text=I%20just%20discover%20{{ config('app.name') }}%20%F0%9F%8E%89!%0A%0AAn%20app%20that%20will%20send%20you%20Real-time%20notifications%20for%20everything%20that%20matters to you.%0A%0ANever%20miss%20a%20beat%20%F0%9F%94%A5&url=https%3A%2F%2F{{ config('app.url') }}">

            <!-- Circle -->
            <div class="">
                <div
                    class="mr-6 flex h-6 w-6 items-center justify-center text-gray-600 dark:text-gray-400 no-underline transition-all duration-300 font-bold">
                    <span class="-mt-2">→</span>
                </div>
            </div>

            <!-- Title and description -->
            <div>Share {{ config('app.name') }} with the world 🥰</div>
        </a>
    </li>
</ul>
