<ul class="space-x-2 items-center hidden sm:flex">
    <li class="group">
        <div class="relative inline-block text-left">
            <div class="flex flex-row items-center">
                <button type="button"
                        class="inline-flex w-full justify-center gap-x-1.5 rounded-md px-3 py-2 hover:bg-gray-50 group-hover:bg-gray-50"
                        id="menu-button"
                        aria-expanded="true"
                        aria-haspopup="true">
                    Why MetricsWave
                    <svg class="-mr-1 h-5 w-5 opacity-40"
                         viewBox="0 0 20 15"
                         fill="currentColor"
                         aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <div class="invisible opacity-0 absolute left-0 z-10 pt-2 w-[350px] origin-top-left focus:outline-none transition-all ease-out duration-500"
                 role="menu"
                 id="menu"
                 aria-orientation="vertical"
                 aria-labelledby="menu-button"
                 tabindex="-1">
                <div class="py-2 bg-white shadow-lg ring-1 ring-black ring-opacity-5 rounded-md"
                     role="none">
                    <a href="/metricswave-vs-google-analytics"
                       class="text-zinc-700 block px-4 py-2 text-sm smooth hover:bg-zinc-100 hover:text-zinc-800"
                       role="menuitem"
                       tabindex="-1"
                       id="menu-item-0">
                        Vs. Google Analytics<br/>
                        <span class="text-xs text-gray-500">MetricsWave is the  best alternative to GA</span>
                    </a>
                    <a href="/metricswave-vs-plausible"
                       class="text-zinc-700 block px-4 py-2 text-sm smooth hover:bg-zinc-100 hover:text-zinc-800"
                       role="menuitem"
                       tabindex="-1"
                       id="menu-item-1">
                        Vs. Plausible<br/>
                        <span class="text-xs text-gray-500">Symple analytics, but configurable</span>
                    </a>

                    <div class="text-zinc-400 px-4 py-2 mt-4 text-xs">
                        Website Analytics for:
                    </div>
                    <a href="/for-european-companies"
                       class="text-zinc-700 block px-4 py-2 text-sm smooth hover:bg-zinc-100 hover:text-zinc-800"
                       role="menuitem"
                       tabindex="-1"
                       id="menu-item-2">European Companies</a>
                    <a href="/for-bootstrappers"
                       class="text-zinc-700 block px-4 py-2 text-sm smooth hover:bg-zinc-100 hover:text-zinc-800"
                       role="menuitem"
                       tabindex="-1"
                       id="menu-item-3">Bootstrapped Companies</a>
                    <a href="/for-open-companies"
                       class="text-zinc-700 block px-4 py-2 text-sm smooth hover:bg-zinc-100 hover:text-zinc-800"
                       role="menuitem"
                       tabindex="-1"
                       id="menu-item-4">Open Companies</a>
                </div>
            </div>
        </div>
    </li>
    <li>
        <a href="/#pricing"
           class="px-3 py-2 hover:underline smooth">Pricing</a>
    </li>
</ul>

<ul class="flex space-x-6 items-center">
    <li class="hidden sm:block">
        <a class="hover:underline smooth linkToApp"
           href="https://app.metricswave.com/auth/login">Log In</a>
    </li>
    <li class="hidden sm:block">
        <a class="hover:underline smooth linkToApp bg-orange-400/10 rounded-md py-1.5 px-3"
           href="https://app.metricswave.com/auth/signup">Free Trial</a>
    </li>
    <li class="sm:hidden">
        <a class="hover:underline smooth linkToApp bg-orange-400/10 rounded-md py-1.5 px-3"
           href="https://app.metricswave.com">App</a>
    </li>
</ul>

<script>
    const menuButton = document.getElementById('menu-button');
    const menu = document.getElementById('menu');

    const close = () => {
        menu.classList.add('invisible')
        menu.classList.add('opacity-0')
        menu.classList.remove('opacity-100')
    }

    const toggle = () => {
        if (menu.classList.contains('invisible')) {
            open()
        } else {
            close()
        }
    }

    const open = () => {
        menu.classList.remove('invisible')
        menu.classList.remove('opacity-0')
        menu.classList.add('opacity-100')
    }

    if (menuButton !== null) {
        menuButton.addEventListener('click', toggle)
        document.addEventListener('click', (event) => {
            if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
                close()
            }
        })
    }
</script>
