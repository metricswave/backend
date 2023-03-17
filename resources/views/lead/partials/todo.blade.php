<ul class="leading-tight -mt-4">
    @foreach($todos as $todo)
        <li>
            <a
                class="items-top group flex cursor-pointer flex-row rounded p-5 transition-all duration-300 hover:animate-none {{ $todo['done'] === false ? "hover:bg-blue-50/75 active:bg-blue-100/50 dark:hover:bg-blue-800/5 dark:active:bg-blue-500/50 bg-red-500/5 mt-4" : "opacity-70 hover:opacity-100" }}"
                href="{{ $todo['link'] }}">

                <!-- Circle -->
                <div class="">
                    <div
                        class="mr-6 flex h-6 w-6 items-center justify-center rounded-full border-2 text-white no-underline transition-all duration-300 group-hover:bg-white/10 {{ $todo['done'] === false ? "bg-zinc-500/10" : 'animate-pulse bg-zinc-500/5' }}">
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
</ul>
