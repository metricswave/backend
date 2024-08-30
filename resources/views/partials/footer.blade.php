<footer class="mt-16 flex flex-col sm:flex-row items-start space-y-8 sm:space-y-0 justify-between px-[var(--app-padding)] pb-[var(--app-padding)] sm:px-10 sm:pb-10 sm:mt-32 md:mt-64">
    <ul class="flex space-y-4 tracking-tighter flex-col">
        <li class="text-sm opacity-50">{{ __("Websites Analytics for") }}:</li>
        <li><a class="hover:underline smooth"
               href="/for-european-companies">European Companies</a></li>
        <li><a class="hover:underline smooth"
               href="/for-agencies">Agencies</a></li>
        <li><a class="hover:underline smooth"
               href="/for-bootstrappers">Bootstrapped Companies</a></li>
        <li><a class="hover:underline smooth"
               href="/for-open-companies">Open Companies</a></li>
    </ul>

    <ul class="flex space-y-4 tracking-tighter flex-col">
        <li class="text-sm opacity-50">{{ __("Why MetricsWave") }}:</li>
        @if (App::getLocale() === "es")
            <li><a class="hover:underline smooth"
                   href="/es/mejor-alternativa-a-google-analytics">MetricsWave vs Google Analytica</a></li>
        @else
            <li><a class="hover:underline smooth"
                   href="/metricswave-vs-google-analytics">MetricsWave vs Google Analytics</a></li>
            <li><a class="hover:underline smooth"
                   href="/metricswave-vs-plausible">MetricsWave vs Plausible</a></li>
            <li><a class="hover:underline smooth"
                   href="/metricswave-vs-fathom">MetricsWave vs Fathom</a></li>
            @endif
    </ul>

    <ul class="flex space-y-4 tracking-tighter flex-col">
        <li class="text-sm opacity-50">{{ __("About us") }}:</li>
        <li><a class="hover:underline smooth"
               href="/documentation">{{ __("Documentation") }}</a></li>
        <li><a class="hover:underline smooth"
               href="/blog/category/changelog">{{ __("Changelog") }}</a></li>
        <li><a class="hover:underline smooth"
               href="/open">{{ __("Open Metrics") }}</a></li>
        <li><a class="hover:underline smooth"
               href="/blog">{{ __("Blog") }}</a></li>
        <li><a href="https://twitter.com/metricswave"
               target="_blank"
               title="@metricswave on Twitter"
               class="hover:underline smooth">Twitter</a></li>
    </ul>

    <ul class="flex space-y-4 tracking-tighter flex-col">
        <li class="text-sm opacity-0">{{ __("Legal links") }}</li>
        <li><a class="hover:underline smooth"
               href="/privacy-policy">{{ __("Privacy Policy") }}</a></li>
        <li><a class="hover:underline smooth"
               href="/terms-and-conditions">{{ __("Terms of Service") }}</a></li>
        <li><a class="flex items-center space-x-3 text-zinc-900 dark:text-white"
               href="/">
                <span class="font-bold tracking-tighter">{{ config('app.name') }} {{ now()->year }}™</span>
            </a></li>
    </ul>
</footer>
