@php use App\Services\Plans\PlanGetter; @endphp
<div>
    <form
        id="payment-form"
        class="flex flex-col gap-3"
    >
        <label>
            <span class="inline-block w-full text-sm">
                {{ __("Name") }}
            </span>

            <input
                type="text"
                wire:model="name"
                id="card-holder-name"
                class="w-full p-3 rounded-sm text-zinc-800 border border-zinc-200 hover:border-zinc-400 transition-all duration-200 ease-in-out"
                placeholder="John Doe"
                autofocus
            />

            <div>@error('name') {{ $message }} @enderror</div>
        </label>

        <label>
            <span class="inline-block w-full text-sm">
                {{ __("Email") }}
            </span>

            <input
                type="email"
                wire:model="email"
                id="card-holder-email"
                class="w-full p-3 rounded-sm text-zinc-800 border border-zinc-200 hover:border-zinc-400 transition-all duration-200 ease-in-out"
                placeholder="john-doe@email.com"
            />

            <div>@error('email') {{ $message }} @enderror</div>
        </label>

        @if ($showPlans)
            <div class="pt-2 pb-2">
                <span class="text-sm">{{ __("Choose one plan") }}:</span>

                <div class="flex flex-col gap-3 pt-1">
                    @foreach($plans as $plan)
                        <a
                            @if($currentPlan->id !== $plan->id)
                                href="?plan={{ ($plan->id->value - 1) }}"
                                wire:click.prevent="changePlan({{ ($plan->id->value - 1) }})"
                            @endif
                            class="group flex-grow flex gap-6 items-start p-3 justify-center rounded-sm border transition-all duration-200 ease-in-out {{ $currentPlan->id === $plan->id ? 'dark:border-zinc-500/60 dark:text-zinc-800 font-bold bg-white' : 'dark:border-blue-800/15 dark:bg-white/5 dark:hover:bg-blue-800/20 dark:hover:border-blue-800/40 cursor-pointer bg-white/20 hover:bg-white/50' }}"
                        >
                            @if($currentPlan->id === $plan->id)
                                <div class="mt-0.5 border border-zinc-400 rounded-full">
                                    <div class="rounded-full aspect-square w-4 bg-blue-500 border-4 border-white"></div>
                                </div>
                            @else
                                <div class="mt-0.5 border border-zinc-400 rounded-full">
                                    <div class="rounded-full aspect-square w-4 bg-white border-4 border-white group-hover:bg-blue-300 transition-all duration-200 ease-in-out"></div>
                                </div>
                            @endif
                            <span class="min-w-[100px]">{{ $plan->name }}</span>
                            <span class="opacity-70 flex-grow">
                            @if($plan->name === "Enterprise")
                                    {{ __("Unlimited traffic") }}
                                @else
                                    {{
                                        $plan->eventsLimit !== null ?
                                            format_long_numbers($plan->eventsLimit, 0) :
                                            'Unlimited'
                                     }} {{ __("visits per month") }}.
                                @endif
                        </span>
                            <span>{!!
                                html_format_currency($plan->monthlyPrice, $this->currencySymbol, '/'.__('mo'))
                            !!}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div
            id="payment-element"
            class="pt-1"
        ></div>

        <div
            id="card-errors"
            class="hidden bg-red-500 text-red-50 p-4 rounded-sm my-4 text-sm"
            role="alert"
        ></div>

        <button
            type="submit"
            id="submit-button"
            class="w-full bg-blue-500 text-white rounded-sm p-4 disabled:bg-zinc-500 transition-all duration-200 ease-in-out"
        >
            {{ __("Upgrade account") }}
            @unless($showPlans)
                ({!! html_format_currency($currentPlan->monthlyPrice, $this->currencySymbol, '/'.__('mo')) !!})
            @endunless
        </button>
    </form>

    <script lang="ts">
        let darkModeEnabledQuery = window.matchMedia('(prefers-color-scheme: dark)')
        let darkModeEnabled = darkModeEnabledQuery.matches

        const stripe = Stripe('{{ config('services.stripe.key') }}', {locale: '{{ App::getLocale() }}'})
        const options = {
            mode: 'subscription',
            currency: '{{ $this->currency }}',
            paymentMethodTypes: ['card'],
            amount: {{ $currentPlan->monthlyPrice }},
            metadata: {
                plan: {{ $currentPlan->id->value }},
                currency: '{{ $currency }}',
            },
            setup_future_usage: 'off_session',
            captureMethod: 'manual',
            appearance: {
                theme: 'flat',
                variables: {
                    colorPrimary: '#0570de',
                    colorDanger: '#df1b41',
                    fontFamily: '"PT Mono", ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
                    fontSmooth: 'always',
                    gridRowSpacing: '20px',
                    gridColumnSpacing: '30px',
                    spacingUnit: '4px',
                    borderRadius: '2px',
                },
                rules: {
                    '.Label': {
                        color: darkModeEnabled ? '#fff' : '#111',
                    },
                    '.Input': {
                        backgroundColor: '#fff',
                        border: darkModeEnabled ? '0' : '1px rgb(228 228 231) solid',
                        transition: 'all 150ms',
                    },
                    '.Input:hover': {
                        border: darkModeEnabled ? '0' : '1px rgb(161 161 170) solid',
                    },
                }
            }
        };
        const elements = stripe.elements(options);
        const paymentElement = elements.create("payment");
        paymentElement.mount("#payment-element");


        darkModeEnabledQuery.addListener(() => {
            elements.update()
        });

        // Submit form
        const form = document.getElementById("payment-form");
        const buttonElement = document.getElementById('submit-button');
        const cardErrorElement = document.getElementById('card-errors')
        cardErrorElement.classList.add('hidden')

        form.addEventListener("submit", async (event) => {
            event.preventDefault();
            buttonElement.disabled = true;
            elements.submit()

            const return_url = '{{ config('app.url') }}{{ App::getLocale() === 'es' ? '/es' : '' }}/upgrading/{{ $teamId }}'

            const {error} = await stripe.confirmSetup(
                {
                    elements,
                    clientSecret: '{{ $this->intentCode }}',
                    confirmParams: {
                        return_url,
                        payment_method_data: {
                            billing_details: {
                                name: document.getElementById('card-holder-name').value,
                                email: document.getElementById('card-holder-email').value,
                            },
                        },
                    },
                }
            );

            if (error) {
                buttonElement.disabled = false
                cardErrorElement.innerHTML = error.message
                cardErrorElement.classList.remove('hidden')
            }
        });
    </script>
</div>
