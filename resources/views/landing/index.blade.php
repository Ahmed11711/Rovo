@extends('layouts.landing')

@section('content')

<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">

        <h1
            class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        @lang('landing.heroTitle')</h1>
        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
            @lang('landing.heroSubTitle')
        </p>
        <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
            <a href="{{ route('restaurant_signup') }}"
                class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-skin-base hover:bg-skin-base/[0.7] focus:ring-4 focus:ring-skin-base dark:focus:ring-skin-base">
                @if($trialPackage)
                    @lang('landing.startTrial', ['days' => $trialPackage->trial_days])
                @else
                    @lang('landing.getStartedFree')
                @endif
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>

        </div>

        <div class="relative  max-w-screen-lg flex justify-center mx-auto">
            <img src="{{ asset('landing/dashboard.png') }}" class="shadow-lg border rounded-lg" alt="">
            <!-- SVG Element -->
            <div class="hidden md:block absolute top-0 end-0 -translate-y-12 translate-x-20">
                <svg class="w-16 h-auto text-skin-base" width="121" height="135" viewBox="0 0 121 135" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 16.4754C11.7688 27.4499 21.2452 57.3224 5 89.0164" stroke="currentColor"
                        stroke-width="10" stroke-linecap="round" />
                    <path d="M33.6761 112.104C44.6984 98.1239 74.2618 57.6776 83.4821 5" stroke="currentColor"
                        stroke-width="10" stroke-linecap="round" />
                    <path d="M50.5525 130C68.2064 127.495 110.731 117.541 116 78.0874" stroke="currentColor"
                        stroke-width="10" stroke-linecap="round" />
                </svg>
            </div>
            <!-- End SVG Element -->

            <!-- SVG Element -->
            <div class="hidden md:block absolute bottom-0 start-0 translate-y-10 -translate-x-32">
                <svg class="w-40 h-auto text-gray-500" width="347" height="188" viewBox="0 0 347 188" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4 82.4591C54.7956 92.8751 30.9771 162.782 68.2065 181.385C112.642 203.59 127.943 78.57 122.161 25.5053C120.504 2.2376 93.4028 -8.11128 89.7468 25.5053C85.8633 61.2125 130.186 199.678 180.982 146.248L214.898 107.02C224.322 95.4118 242.9 79.2851 258.6 107.02C274.299 134.754 299.315 125.589 309.861 117.539L343 93.4426"
                        stroke="currentColor" stroke-width="7" stroke-linecap="round" />
                </svg>
            </div>
            <!-- End SVG Element -->
        </div>

    </div>
</section>

<!-- Features -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto space-y-8">

    <!-- Title -->
    <div class="mx-auto mb-8 lg:mb-14 text-center">
        <h2 class="text-3xl lg:text-4xl text-gray-800 font-bold dark:text-neutral-200">
            @lang('landing.featureSection1')
        </h2>
    </div>
    <!-- End Title -->

    <!-- Grid -->
    <div class="md:grid md:grid-cols-2 md:items-center md:gap-12 xl:gap-32">
        <div>
            <img class="rounded-xl border border-gray-100 shadow" src="{{ asset('landing/order-management.png') }}"
                alt="order management">
        </div>
        <!-- End Col -->

        <div class="mt-5 sm:mt-10 lg:mt-0">
            <div class="space-y-6 sm:space-y-8">
                <!-- Title -->
                <div class="space-y-2 md:space-y-4">
                    <h2 class="font-bold text-3xl lg:text-4xl text-gray-800 dark:text-neutral-200">
                        @lang('landing.featureTitle1')
                    </h2>
                    <p class="text-gray-500 dark:text-neutral-500">
                        @lang('landing.featureDescription1')
                    </p>
                </div>
                <!-- End Title -->

            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Grid -->

    <!-- Grid -->
    <div class="md:grid md:grid-cols-2 md:items-center md:gap-12 xl:gap-32">

        <div class="mt-5 sm:mt-10 lg:mt-0">
            <div class="space-y-6 sm:space-y-8">
                <!-- Title -->
                <div class="space-y-2 md:space-y-4">
                    <h2 class="font-bold text-3xl lg:text-4xl text-gray-800 dark:text-neutral-200">
                        @lang('landing.featureTitle2')
                    </h2>
                    <p class="text-gray-500 dark:text-neutral-500">
                        @lang('landing.featureDescription2')
                    </p>
                </div>
                <!-- End Title -->

            </div>
        </div>
        <!-- End Col -->
        <div>
            <img class="rounded-xl border border-gray-100 shadow" src="{{ asset('landing/table-reservation.png') }}"
                alt="order management">
        </div>
        <!-- End Col -->

    </div>
    <!-- End Grid -->

    <!-- Grid -->
    <div class="md:grid md:grid-cols-2 md:items-center md:gap-12 xl:gap-32">
        <div>
            <img class="rounded-xl border border-gray-100 shadow" src="{{ asset('landing/menu-management.png') }}"
                alt="order management">
        </div>
        <!-- End Col -->

        <div class="mt-5 sm:mt-10 lg:mt-0">
            <div class="space-y-6 sm:space-y-8">
                <!-- Title -->
                <div class="space-y-2 md:space-y-4">
                    <h2 class="font-bold text-3xl lg:text-4xl text-gray-800 dark:text-neutral-200">
                        @lang('landing.featureTitle3')
                    </h2>
                    <p class="text-gray-500 dark:text-neutral-500">
                        @lang('landing.featureDescription3')
                    </p>
                </div>
                <!-- End Title -->

            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Grid -->

</div>
<!-- End Features -->

<!-- Icon Blocks -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto" id="icon-features">

    <!-- Title -->
    <div class="mx-auto  mb-8 lg:mb-14 text-center">
        <h2 class="text-3xl lg:text-4xl text-gray-800 font-bold dark:text-neutral-200">
            @lang('landing.featureSection2')
        </h2>
    </div>
    <!-- End Title -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-12">

        <!-- Icon Block -->
        <div>
            <div
                class="relative flex justify-center items-center size-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-gray-700 before:via-transparent before:to-gray-600 before:rounded-xl dark:bg-neutral-900">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-qr-code-scan text-skin-base dark:text-skin-base size-6" viewBox="0 0 16 16">
                    <path
                        d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z" />
                    <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z" />
                    <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z" />
                    <path
                        d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z" />
                    <path d="M12 9h2V8h-2z" />
                </svg>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('landing.iconFeature1')</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.iconFeatureDesc1')</p>
            </div>
        </div>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <div>
            <div
                class="relative flex justify-center items-center size-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-gray-700 before:via-transparent before:to-gray-600 before:rounded-xl dark:bg-neutral-900">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-qr-code-scan text-skin-base dark:text-skin-base size-6" viewBox="0 0 16 16">
                    <path
                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.226 5.385c-.584 0-.937.164-.937.593 0 .468.607.674 1.36.93 1.228.415 2.844.963 2.851 2.993C11.5 11.868 9.924 13 7.63 13a7.7 7.7 0 0 1-3.009-.626V9.758c.926.506 2.095.88 3.01.88.617 0 1.058-.165 1.058-.671 0-.518-.658-.755-1.453-1.041C6.026 8.49 4.5 7.94 4.5 6.11 4.5 4.165 5.988 3 8.226 3a7.3 7.3 0 0 1 2.734.505v2.583c-.838-.45-1.896-.703-2.734-.703" />
                </svg>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('landing.iconFeature2')</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.iconFeatureDesc2')</p>
            </div>
        </div>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <div>
            <div
                class="relative flex justify-center items-center size-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-gray-700 before:via-transparent before:to-gray-600 before:rounded-xl dark:bg-neutral-900">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-qr-code-scan text-skin-base dark:text-skin-base size-6" viewBox="0 0 16 16">
                    <path
                        d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                </svg>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('landing.iconFeature3')</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.iconFeatureDesc3')</p>
            </div>
        </div>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <div>
            <div
                class="relative flex justify-center items-center size-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-gray-700 before:via-transparent before:to-gray-600 before:rounded-xl dark:bg-neutral-900">
                <svg class="size-6 transition duration-75 text-skin-base dark:text-skin-base" fill="currentColor"
                    viewBox="0 -0.5 25 25" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd"
                            d="M16,6 L20,6 C21.1045695,6 22,6.8954305 22,8 L22,16 C22,17.1045695 21.1045695,18 20,18 L16,18 L16,19.9411765 C16,21.0658573 15.1177541,22 14,22 L4,22 C2.88224586,22 2,21.0658573 2,19.9411765 L2,4.05882353 C2,2.93414267 2.88224586,2 4,2 L14,2 C15.1177541,2 16,2.93414267 16,4.05882353 L16,6 Z M20,11 L16,11 L16,16 L20,16 L20,11 Z M14,19.9411765 L14,4.05882353 C14,4.01396021 13.9868154,4 14,4 L4,4 C4.01318464,4 4,4.01396021 4,4.05882353 L4,19.9411765 C4,19.9860398 4.01318464,20 4,20 L14,20 C13.9868154,20 14,19.9860398 14,19.9411765 Z M5,19 L5,17 L7,17 L7,19 L5,19 Z M8,19 L8,17 L10,17 L10,19 L8,19 Z M11,19 L11,17 L13,17 L13,19 L11,19 Z M5,16 L5,14 L7,14 L7,16 L5,16 Z M8,16 L8,14 L10,14 L10,16 L8,16 Z M11,16 L11,14 L13,14 L13,16 L11,16 Z M13,5 L13,13 L5,13 L5,5 L13,5 Z M7,7 L7,11 L11,11 L11,7 L7,7 Z M20,9 L20,8 L16,8 L16,9 L20,9 Z">
                        </path>
                    </g>
                </svg>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('landing.iconFeature4')</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.iconFeatureDesc4')</p>
            </div>
        </div>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <div>
            <div
                class="relative flex justify-center items-center size-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-gray-700 before:via-transparent before:to-gray-600 before:rounded-xl dark:bg-neutral-900">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-qr-code-scan text-skin-base dark:text-skin-base size-6" viewBox="0 0 16 16">
                    <path
                        d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882zm3.515 7.008L14.438 10 8 13.433 1.562 10 4.25 8.567l3.515 1.874a.5.5 0 0 0 .47 0zM8 9.433 1.562 6 8 2.567 14.438 6z" />
                </svg>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('landing.iconFeature5')</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.iconFeatureDesc5')</p>
            </div>
        </div>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <div>
            <div
                class="relative flex justify-center items-center size-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-gray-700 before:via-transparent before:to-gray-600 before:rounded-xl dark:bg-neutral-900">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-qr-code-scan text-skin-base dark:text-skin-base size-6" viewBox="0 0 16 16">
                    <path
                        d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                    <path
                        d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                </svg>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('landing.iconFeature6')</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.iconFeatureDesc6')</p>
            </div>
        </div>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <div>
            <div
                class="relative flex justify-center items-center size-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-gray-700 before:via-transparent before:to-gray-600 before:rounded-xl dark:bg-neutral-900">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-qr-code-scan text-skin-base dark:text-skin-base size-6" viewBox="0 0 16 16">
                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                    <path
                        d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                </svg>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('landing.iconFeature7')</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.iconFeatureDesc7')</p>
            </div>
        </div>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <div>
            <div
                class="relative flex justify-center items-center size-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-gray-700 before:via-transparent before:to-gray-600 before:rounded-xl dark:bg-neutral-900">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-qr-code-scan text-skin-base dark:text-skin-base size-6" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
                </svg>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('landing.iconFeature8')</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.iconFeatureDesc8')</p>
            </div>
        </div>
        <!-- End Icon Block -->

    </div>
</div>
<!-- End Icon Blocks -->

<!-- Testimonials -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

    <!-- Title -->
    <div class="mx-auto  mb-8 lg:mb-14 text-center">
        <h2 class="text-3xl lg:text-4xl text-gray-800 font-bold dark:text-neutral-200">
            @lang('landing.testimonialSection1')
        </h2>
    </div>
    <!-- End Title -->

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card -->
        <div
            class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
            <div class="flex-auto p-4 md:p-6">


                <p class="text-base text-gray-800 md:text-xl dark:text-white"><em>
                        " @lang('landing.testimonial1') "
                    </em></p>
            </div>

            <div class="p-4 rounded-b-xl md:px-6">
                <h3 class="text-sm font-semibold text-gray-800 sm:text-base dark:text-neutral-200">
                    @lang('landing.testimonialName1')
                </h3>
                <p class="text-sm text-gray-500 dark:text-neutral-500">
                    @lang('landing.testimonialDesignation1')
                </p>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div
            class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
            <div class="flex-auto p-4 md:p-6">


                <p class="text-base text-gray-800 md:text-xl dark:text-white"><em>
                        " @lang('landing.testimonial2') "
                    </em></p>
            </div>

            <div class="p-4 rounded-b-xl md:px-6">
                <h3 class="text-sm font-semibold text-gray-800 sm:text-base dark:text-neutral-200">
                    @lang('landing.testimonialName2')
                </h3>
                <p class="text-sm text-gray-500 dark:text-neutral-500">
                    @lang('landing.testimonialDesignation2')
                </p>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div
            class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
            <div class="flex-auto p-4 md:p-6">


                <p class="text-base text-gray-800 md:text-xl dark:text-white"><em>
                        " @lang('landing.testimonial3') "
                    </em></p>
            </div>

            <div class="p-4 rounded-b-xl md:px-6">
                <h3 class="text-sm font-semibold text-gray-800 sm:text-base dark:text-neutral-200">
                    @lang('landing.testimonialName3')
                </h3>
                <p class="text-sm text-gray-500 dark:text-neutral-500">
                    @lang('landing.testimonialDesignation3')
                </p>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Grid -->
</div>
<!-- End Testimonials -->


<!-- Features -->
<div class="overflow-hidden" id="simple-pricing">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title -->
        <div class="mx-auto mb-8 lg:mb-14 text-center">
            <h2 class="text-3xl lg:text-4xl text-gray-800 font-bold dark:text-neutral-200">
                @lang('landing.pricingTitle1')
            </h2>
            <p class="my-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                @lang('landing.pricingSubTitle1')
            </p>
        </div>
        <!-- End Title -->
        @include('landing.pricing', ['packages' => $packages, 'modules' => $modules])

    </div>
</div>
<!-- End Features -->

<!-- FAQ -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto" id="user-faqs">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
      <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">@lang('landing.faqTitle1')</h2>
      <p class="mt-1 text-gray-600 dark:text-neutral-400">@lang('landing.faqSubTitle1')</p>
    </div>
    <!-- End Title -->

    <div class="max-w-5xl mx-auto">
        <!-- Grid -->
        <div class="grid sm:grid-cols-2 gap-6 md:gap-12">
          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                @lang('landing.faqQues1')
            </h3>
            <p class="mt-2 text-gray-600 dark:text-neutral-400">
                @lang('landing.faqAns1')
            </p>
          </div>
          <!-- End Col -->

          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                @lang('landing.faqQues2')
            </h3>
            <p class="mt-2 text-gray-600 dark:text-neutral-400">
                @lang('landing.faqAns2')
            </p>
          </div>
          <!-- End Col -->

          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                @lang('landing.faqQues3')
            </h3>
            <p class="mt-2 text-gray-600 dark:text-neutral-400">
                @lang('landing.faqAns3')
            </p>
          </div>
          <!-- End Col -->


          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                @lang('landing.faqQues4')
            </h3>
            <p class="mt-2 text-gray-600 dark:text-neutral-400">
                @lang('landing.faqAns4')
            </p>
          </div>
          <!-- End Col -->

          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                @lang('landing.faqQues5')
            </h3>
            <p class="mt-2 text-gray-600 dark:text-neutral-400">
                @lang('landing.faqAns5')
            </p>
          </div>
          <!-- End Col -->


          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                @lang('landing.faqQues6')
            </h3>
            <p class="mt-2 text-gray-600 dark:text-neutral-400">
                @lang('landing.faqAns6')
            </p>
          </div>
          <!-- End Col -->

        </div>
        <!-- End Grid -->
    </div>

</div>
  <!-- End FAQ -->

<!-- Contact -->
<div class="max-w-7xl px-4 lg:px-8 py-12 lg:py-24 mx-auto">
    <div class="mb-6 sm:mb-10 max-w-2xl text-center mx-auto">
      <h2 class="font-medium text-black text-2xl sm:text-4xl dark:text-white">
        @lang('landing.contactTitle')
      </h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 lg:items-center gap-6 md:gap-8 lg:gap-12">
      <div class="aspect-w-16 aspect-h-6 lg:aspect-h-14 overflow-hidden bg-gray-100 rounded-2xl dark:bg-neutral-800">
        <img class="group-hover:scale-105 group-focus:scale-105 transition-transform duration-500 ease-in-out object-cover rounded-2xl" src="https://images.unsplash.com/photo-1572021335469-31706a17aaef?q=80&w=560&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Contacts Image">
      </div>
      <!-- End Col -->

      <div class="space-y-8 lg:space-y-16">
        <div>
          <h3 class="mb-5 font-semibold text-black dark:text-white">
            @lang('landing.addressTitle')
          </h3>

          <!-- Grid -->
          <div class="grid gap-4 sm:gap-6 md:gap-8 lg:gap-12">
            <div class="flex gap-4">
              <svg class="shrink-0 size-5 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>

              <div class="grow">
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    @lang('landing.contactCompany')
                </p>
                <address class="mt-1 text-black not-italic dark:text-white">
                    @lang('landing.contactAddress')
                </address>
              </div>
            </div>

            <div class="flex gap-4">
                <svg class="shrink-0 size-5 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.2 8.4c.5.38.8.97.8 1.6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 .8-1.6l8-6a2 2 0 0 1 2.4 0l8 6Z"></path><path d="m22 10-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 10"></path></svg>

                <div class="grow">
                  <p class="text-sm text-gray-600 dark:text-neutral-400">
                    @lang('landing.emailTitle')
                  </p>
                  <p>
                    <a class="relative inline-block font-medium text-black before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-skin-base hover:before:bg-black focus:outline-none focus:before:bg-black dark:text-white dark:hover:before:bg-white dark:focus:before:bg-white" href="mailto:@lang('landing.contactEmail')">
                    @lang('landing.contactEmail')
                    </a>
                  </p>
                </div>
              </div>

          </div>
          <!-- End Grid -->
        </div>

      </div>
      <!-- End Col -->
    </div>
</div>
<!-- End Contact -->

@endsection
