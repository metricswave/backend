@extends('layouts.minimal_landing')

@section('content')
    <div class="max-w-[400px] m-auto h-screen my-20 flex flex-col space-y-4 sm:space-y-4 sm:my-40">
        <h2 class="mb-0 text-xl sm:text-3xl font-bold">Create your account</h2>
        <p class="mb-2 sm:mb-6 max-w-[600px]">We just need your email to create your account.</p>
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
                Sign Up
            </button>
        </form>
    </div>
@endsection
