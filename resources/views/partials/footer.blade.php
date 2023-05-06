<footer class="mt-16 flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 justify-between px-10 pb-10 sm:mt-32 md:mt-64">
    <ul>
        <li class="flex">
            <a class="flex items-center space-x-3 text-zinc-900 dark:text-white"
               href="/">
                <span class="font-bold tracking-tighter">{{ config('app.name') }} {{ now()->year }}™</span>
            </a>
        </li>
    </ul>

    <ul class="flex space-y-4 tracking-tighter flex-col">
        <li><a class="hover:underline smooth"
               href="/open">Open Metrics</a></li>
        <li><a class="hover:underline smooth"
               href="/blog">Blog</a></li>
        <li><a href="https://twitter.com/notify_wave"
               target="_blank"
               title="@notify_wave on Twitter"
               class="hover:underline smooth">Twitter</a></li>
    </ul>

    <ul class="flex space-y-4 tracking-tighter flex-col">
        <li><a class="hover:underline smooth"
               href="/roadmap">Roadmap</a></li>
        <li><a class="hover:underline smooth"
               href="/documentation">Documentation</a></li>
        <li><a class="hover:underline smooth"
               href="/blog/category/changelog">Changelog</a></li>
    </ul>

    <ul class="flex space-y-4 tracking-tighter flex-col">
        <li><a class="hover:underline smooth"
               href="/privacy-policy">Privacy Policy</a></li>
        <li><a class="hover:underline smooth"
               href="/terms-and-conditions">Terms of Service</a></li>
    </ul>
</footer>
