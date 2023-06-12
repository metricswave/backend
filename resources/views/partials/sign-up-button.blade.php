<a
    class="py-4 px-6 text-center bg-gradient-to-b from-slate-800 via-black to-black dark:from-zinc-800 dark:via-zinc-800 dark:to-zinc-800 hover:bg-gradient-to-b hover:from-slate-600 hover:via-slate-900 hover:to-black hover:dark:from-zinc-700 hover:dark:via-zinc-700 hover:dark:to-zinc-700 text-white block mx-auto rounded-lg shadow-lg hover:shadow smooth"
    href="{{ config('app.web_app_url') }}?utm_source={{ $utmSource ?? 'sign-up-button' }}"
>
    {{ $buttonText ?? 'Start Tracking my Product →' }}
</a>
