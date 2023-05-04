@extends('layouts.landing')

@section('meta')
@endsection

@section('content')
    <div class="flex flex-col items-center justify-center space-y-14 sm:space-y-16">
        <div class="mx-auto flex flex-col space-y-8 mt-20 mb-8 sm:mt-40 sm:mb-8 max-w-[750px]">
            <h1 class="animate-[out_1s,_fade-in-down_1.5s_ease-out_1s] text-4xl sm:text-6xl text-center leading-tight sm:leading-tight tracking-tighter">
                A notifications<br/>for every
                <span class="relative bg-gradient-to-br from-pink-500 to-amber-500 bg-clip-text text-transparent">deployment</span>
                you or your team makes
            </h1>

            <p class="animate-[out_1.25s,_fade-in-down_1.5s_ease-out_1.25s] text-center text-xl sm:text-2xl leading-normal sm:leading-normal opacity-70 sm:pb-6">
                Receive a notification on all your devices when a deployment is finished and get a summary of the
                deployment.
            </p>

            @if(config('feature.sign_up_leads_only'))
                <a class="animate-[out_1.75s,_fade-in-down_1.5s_ease-out_1.75s] py-4 px-6 text-center bg-gradient-to-b from-zinc-800 dark:from-zinc-700 via-black dark:via-zinc-800 to-black dark:to-zinc-800 hover:bg-gradient-to-b hover:from-zinc-700 hover:via-zinc-900 hover:to-black text-white block mx-auto rounded-lg shadow-lg hover:shadow smooth"
                   href="/leads?utm_source=deployments_landing">Create your notification</a>
            @else
                <a class="animate-[out_1.75s,_fade-in-down_1.5s_ease-out_1.75s] py-4 px-6 text-center bg-gradient-to-b from-slate-800 via-black to-black hover:bg-gradient-to-b hover:from-slate-600 hover:via-slate-900 hover:to-black text-white block mx-auto rounded-lg shadow-lg hover:shadow smooth"
                   href="{{ config('app.web_app_url') }}?utm_source=deployments_landing">Create your notification</a>
            @endif
        </div>

        <div class="animate-[out_2.5s,_fade-in-down_1.5s_ease-out_2.5s] mw-landing flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <div>
                <div class="flex flex-row items-center justify-center">
                    <h2>Customize it as you like </h2>
                    <svg width="25px"
                         height="25px"
                         class="ml-3 mt-1"
                         viewBox="0 0 24 24"
                         fill=""
                         xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier"
                           stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier"
                           stroke-linecap="round"
                           stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M14 20L13.6464 20.3536L14 20.7071L14.3536 20.3536L14 20ZM6 3.5C5.72386 3.5 5.5 3.72386 5.5 4C5.5 4.27614 5.72386 4.5 6 4.5L6 3.5ZM8.64645 15.3536L13.6464 20.3536L14.3536 19.6464L9.35355 14.6464L8.64645 15.3536ZM14.3536 20.3536L19.3536 15.3536L18.6464 14.6464L13.6464 19.6464L14.3536 20.3536ZM14.5 20L14.5 10L13.5 10L13.5 20L14.5 20ZM8 3.5L6 3.5L6 4.5L8 4.5L8 3.5ZM14.5 10C14.5 6.41015 11.5899 3.5 8 3.5L8 4.5C11.0376 4.5 13.5 6.96243 13.5 10L14.5 10Z"
                                  fill="currentColor"></path>
                        </g>
                    </svg>
                </div>

                <img src="/images/landings/20230430174544_deployment_trigger.png"
                     class="shadow dark:border dark:border-zinc-800 dark:shadow-zinc-800 rounded mt-3 shadow-lg max-w-full w-[450px]"
                     title="Deployment trigger">
            </div>
        </div>


        <div class="mw-wide-landing flex flex-col-reverse sm:flex-row items-center justify-center sm:space-y-0 sm:space-x-10 py-12 sm:py-24 md:py-36">
            <div class="flex flex-col space-y-3">
                <h2 class="text-xl sm:text-2xl leading-tight sm:leading-tight tracking-tighter font-bold">
                    More than just a notification
                </h2>
                <p>
                    You can also get a summary of the deployment, including the commit message, the branch, the
                    environment, the user who triggered the deployment, and what ever you want.
                </p>
                <p class="pt-2">
                    → <a class="text-blue-500 underline hover:no-underline smooth"
                         href="/documentation/deployment-notification">How to trigger a notification after a
                        deployment</a>
                </p>
            </div>

            <img src="/images/landings/20230430181658_deployment_notification.png"
                 class="pb-10 sm:pb-0 max-w-[300px]"
                 alt="Deployment notification">
        </div>
    </div>


    <div class="mw-landing m-auto my-20 flex flex-col sm:items-center justify-center space-y-4 sm:space-y-8 sm:my-40">
        <h2 class="mb-0 text-xl sm:mb-2 sm:text-3xl font-bold">Haven't you signed up yet?</h2>
        <p class="sm:text-center mb-2 sm:mb-16 max-w-[600px]">
            Leave us your email, and we will notify you of all progress. You can also help us <strong>define the future
                of {{ config('app.name') }}</strong> and even get a lifetime license at a single price.
        </p>
        @include('landing.lead-form')
    </div>
@endsection
