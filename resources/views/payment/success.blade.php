@extends('layouts.minimal_landing')

@section('content')
    <div class="max-w-[400px] m-auto h-screen my-20 flex flex-col space-y-4 sm:space-y-4 sm:my-40">
        <div class="flex flex-col space-y-4">
            <h2 class="mb-6 text-xl sm:text-3xl font-bold">Thank you! 🎉</h2>
            <p>You will receive an email from Stripe with your payment information soon.</p>
            <p>You can also access your private section using the email you used to pay below.</p>
            <p><strong>We are inviting to the beta those users who have a license little by little</strong>, you are
                already on the list,
                now it's just a matter of time.</p>
        </div>

        <div class="flex flex-col space-y-4 pt-10">
            <h2 class="mb-0 text-lg sm:text-xl font-bold">Access your private section</h2>
            <p>Write the email with which you made the payment.</p>
            <form action="/leads"
                  class="flex w-full flex-col space-y-2"
                  method="POST">
                @csrf
                <input
                    class="w-full rounded border bg-white/50 p-4 shadow transition-all duration-200 hover:bg-white/70 active:bg-white/95 dark:border-zinc-700 dark:bg-zinc-800/50 dark:hover:border-zinc-600 dark:hover:bg-zinc-800/75 dark:focus:border-blue-500 dark:focus:bg-zinc-800 w-full flex-grow sm:w-auto"
                    name="email"
                    required
                    placeholder="Your email"
                    type="email"/>
                <button
                    class="w-full px-10 sm:w-auto md:px-14 border-blue-500 bg-blue-600/80 text-white hover:bg-blue-600 active:bg-blue-700 py-3 w-full rounded border py-3 shadow transition-all duration-200 active:shadow-none"
                    type="submit">
                    Access private section
                </button>
            </form>
        </div>
    </div>
@endsection
