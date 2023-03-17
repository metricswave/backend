<div class="mt-10 flex flex-row items-center space-x-10">
    <div class="w-full sm:min-w-[375px]">
        <div class="group relative w-full">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 to-blue-500 animate-tilt rounded-xl opacity-10 blur transition duration-[2s] group-hover:opacity-50 group-hover:duration-300"></div>
            <div class="rounded-xl bg-white/80 p-5 backdrop-blur-xl dark:bg-black/60 flex flex-col items-start space-y-4">
                <h4 class="font-bold">Configure your notification:</h4>
                <label class="flex w-full flex-col space-y-2"><span>Title</span>
                    <input class="w-full rounded border bg-white/50 p-4 shadow transition-all duration-200 hover:bg-white/70 active:bg-white/95 dark:border-zinc-700 dark:bg-zinc-800/50 dark:hover:border-zinc-600 dark:hover:bg-zinc-800/75 dark:focus:border-blue-500 dark:focus:bg-zinc-800 undefined"
                           value="🚗 Time to leave: {event.name}"
                           placeholder="Title"
                           type="text"></label> <label class="flex w-full flex-col space-y-2"><span>Description</span>
                    <textarea class="h-24 rounded border bg-white/50 p-3 shadow transition-all duration-200 hover:bg-white/70 active:bg-white/95 dark:border-zinc-700 dark:bg-zinc-800/50 dark:hover:border-zinc-600 dark:hover:bg-zinc-800/75 dark:focus:border-blue-500 dark:focus:bg-zinc-800">Leave now to be at {event.location}. Estimated time of arrival is {eta}.</textarea></label>
                <button class="undefined dark:hover:bg-zinc-800/75 dark:active:bg-zinc-800 dark:active:border-zinc-700 dark:border-zinc-600 bg-white/50 hover:bg-white/70 active:bg-white/95 py-4 w-full rounded border py-2 shadow transition-all duration-200 active:shadow-none"
                        value="Save">Save
                </button>
            </div>
        </div>
    </div>
    <div class="hidden flex-col space-y-6 text-sm opacity-75 sm:flex"><p><strong>Unlimited options:</strong></p>
        <p>You can use params from the trigger to configure the notification as you want, and apply filters to avoid
            some notifications.</p>
        <p>Imagine also being able to configure actions such as opening the map with the route. Everything, with a
            click.</p></div>
</div>
