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
                class="w-full p-3 rounded-sm"
                placeholder="John Doe"
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
                class="w-full p-3 rounded-sm"
                placeholder="john-doe@email.com"
            />

            <div>@error('email') {{ $message }} @enderror</div>
        </label>

        @if ($showPlans)
            <div class="pt-2 pb-2">
                <span class="text-sm">{{ __("Choose one plan") }}:</span>

                <div class="flex flex-col gap-3 pt-1">
                    @foreach((new PlanGetter())->paidPlans() as $plan)
                        <div
                            class="flex-grow flex gap-6 items-start p-3 justify-center rounded-sm border transition-all duration-200 ease-in-out {{ $currentPlan->id === $plan->id ? 'dark:border-blue-500/60 dark:bg-blue-800/40 font-bold' : 'dark:border-blue-800/15 dark:bg-blue-800/5 dark:hover:bg-blue-800/20 dark:hover:border-blue-800/40 cursor-pointer' }}"
                        >
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
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div
            id="payment-element"
            class="pt-1"
        >
            <!-- Elements will create input elements here -->
        </div>

        <div
            id="card-errors"
            role="alert"
        ></div>

        <button type="submit"
                class="w-full bg-blue-500 rounded-sm p-4">
            {{ __("Upgrade account") }}
            @unless($showPlans)
                ({!! html_format_currency($currentPlan->monthlyPrice, $this->currencySymbol, '/'.__('mo')) !!})
            @endunless
        </button>
    </form>

    <script lang="ts">
        var stripe = Stripe('{{ config('services.stripe.key') }}', {
            locale: '{{ App::getLocale() }}'
        });

        const options = {
            mode: 'subscription',
            currency: '{{ $this->currency }}',
            amount: {{ $currentPlan->monthlyPrice }},
            setup_future_usage: 'off_session',
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
                        color: '#fff',
                    }
                }
            }
        };
        const elements = stripe.elements(options);


        // Set up Stripe.js and Elements to use in checkout form
        const paymentElement = elements.create("payment", {
            // layout: 'accordion',
            defaultValues: {},
            fields: {
                billingDetails: 'never'
            },
        });
        paymentElement.mount("#payment-element");


        // Submit form
        const form = document.getElementById("payment-form");
        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            if (!stripe) {
                // Stripe.js hasn't yet loaded.
                // Make sure to disable form submission until Stripe.js has loaded.
                return;
            }

            setLoading(true);

            // Trigger form validation and wallet collection
            const {error: submitError} = await elements.submit();
            if (submitError) {
                handleError(submitError);
                return;
            }

            // Create the PaymentIntent and obtain clientSecret
            const res = await fetch("/create-intent", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
            });

            const {client_secret: clientSecret} = await res.json();

            // Use the clientSecret and Elements instance to confirm the setup
            const {error} = await stripe.confirmPayment({
                elements,
                clientSecret,
                confirmParams: {
                    return_url: 'https://example.com/order/123/complete',
                },
                // Uncomment below if you only want redirect for redirect-based payments
                // redirect: "if_required",
            });

            if (error) {
                handleError(error);
            }
        });
    </script>
</div>
