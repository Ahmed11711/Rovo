<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @php
        $lastSegment = last(request()->segments());
        $isHash = preg_match('/^[a-f0-9]{32,}$/', $lastSegment);
    @endphp

    <link rel="manifest" href="{{ asset('manifest.json') }}@if($isHash)?hash={{ $lastSegment }}@endif" crossorigin="use-credentials">

    {{-- <link rel="manifest" href="{{ asset('manifest.json')}}"> --}}
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Table Track">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ global_setting()->logoUrl }}"> --}}

    @if (File::exists(public_path('user-uploads/favicons/super-admin/apple-touch-icon.png')))
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('user-uploads/favicons/super-admin/apple-touch-icon.png') }}">
    @endif
    @if (File::exists(public_path('user-uploads/favicons/super-admin/android-chrome-192x192.png')))
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('user-uploads/favicons/super-admin/android-chrome-192x192.png') }}">
    @endif
    @if (File::exists(public_path('user-uploads/favicons/super-admin/android-chrome-512x512.png')))
        <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('user-uploads/favicons/super-admin/android-chrome-512x512.png') }}">
    @endif
    @if (File::exists(public_path('user-uploads/favicons/super-admin/favicon-16x16.png')))
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('user-uploads/favicons/super-admin/favicon-16x16.png') }}">
    @endif
    @if (File::exists(public_path('user-uploads/favicons/super-admin/favicon-32x32.png')))
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('user-uploads/favicons/super-admin/favicon-32x32.png') }}">
    @endif
    @if (File::exists(public_path('user-uploads/favicons/super-admin/favicon.ico')))
        <link rel="shortcut icon" href="{{ asset('user-uploads/favicons/super-admin/favicon.ico') }}">
    @endif
    @if (File::exists(public_path('user-uploads/favicons/super-admin/site.webmanifest')))
        <link rel="manifest" href="{{ asset('user-uploads/favicons/super-admin/site.webmanifest') }}">
    @endif
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ global_setting()->logoUrl }}">
    @if (global_setting()->meta_keyword)
        <meta name="keyword" content="{{ global_setting()->meta_keyword ?? '' }}">
    @endif
    @if (global_setting()->meta_description)
        <meta name="description" content="{{ global_setting()->meta_description ?? '' }}">
    @endif
    <title>{{ global_setting()->name }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    @include('sections.theme_style', ['baseColor' => global_setting()->theme_rgb, 'baseColorHex' => global_setting()->theme_hex])

</head>

<body class="font-sans antialiased dark:bg-gray-900">

    <div class="mx-auto max-w-lg lg:max-w-screen-xl min-h-svh shadow-md lg:shadow-none">
        <header class="lg:hidden">
            <nav class="bg-white border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:text-gray">
                <div class="flex flex-wrap justify-between items-center mx-auto">
                    <a href="{{ url('/') }}" class="flex items-center gap-1">
                        <img src="{{ global_setting()->logoUrl }}" class="ltr:mr-3 rtl:ml-3 h-6 sm:h-9"
                            alt="App Logo" />
                        @if (global_setting()->show_logo_text)
                            <span
                                class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ global_setting()->name }}</span>
                        @endif
                    </a>
                    <div class="flex items-center">
                        <button data-collapse-toggle="mobile-menu-2" type="button"
                            class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="mobile-menu-2" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden justify-between items-center w-full bg-gray-50 dark:bg-gray-700 mt-4 rounded-md"
                        id="mobile-menu-2">
                        <ul class="flex flex-col font-medium ">
                            <li>
                                <a href="{{ url('/') }}" wire:navigate
                                    class="block py-2 pr-4 pl-3 text-gray-700 rounded dark:text-white">@lang('menu.home')</a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#icon-features" wire:navigate
                                    class="block py-2 pr-4 pl-3 text-gray-700 rounded dark:text-white">@lang('landing.features')</a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#simple-pricing" wire:navigate
                                    class="block py-2 pr-4 pl-3 text-gray-700 rounded dark:text-white">@lang('landing.pricing')</a>
                            </li>

                            <li>
                                <a href="{{ route('login') }}" wire:navigate
                                    class="block py-2 pr-4 pl-3 text-gray-700 rounded dark:text-white">
                                    @if (user())
                                        @lang('menu.dashboard')
                                    @else
                                        @lang('app.login')
                                    @endif
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('restaurant_signup') }}" wire:navigate
                                    class="block py-2 pr-4 pl-3 text-gray-700 rounded dark:text-white">@lang('landing.getStarted')</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <header class="hidden lg:block z-50 sticky top-0 inset-x-0">
            <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800 sticky top-4 rounded-md mt-2 ">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                    <a href="{{ url('/') }}" class="flex items-center gap-1">
                        <img src="{{ global_setting()->logoUrl }}" class="ltr:mr-3 rtl:ml-3 h-6 sm:h-9"
                            alt="App Logo" />
                        @if (global_setting()->show_logo_text)
                            <span
                                class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ global_setting()->name }}</span>
                        @endif
                    </a>
                    <div class="flex items-center lg:order-2">

                        <button id="theme-toggle" data-tooltip-target="tooltip-toggle" type="button"
                            class=" text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-4">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    fill-rule="evenodd" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div id="tooltip-toggle" role="tooltip"
                            class="hidden absolute z-10 invisible px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                            Toggle dark mode
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>


                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg font-semibold text-sm text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                            wire:click="$dispatch('showSignup')">
                            @if (user())
                                @lang('menu.dashboard')
                            @else
                                @lang('app.login')
                            @endif
                        </a>

                        @if (!user())
                            <a href="{{ route('restaurant_signup') }}"
                                class="text-white justify-center bg-skin-base hover:bg-skin-base/[.8] sm:w-auto dark:bg-skin-base dark:hover:bg-skin-base/[0.7] font-semibold rounded-lg text-sm px-5 py-2.5 text-center ml-2"
                                wire:click="$dispatch('showSignup')">@lang('landing.getStarted')</a>
                        @endif
                        <button data-collapse-toggle="mobile-menu-2" type="button"
                            class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="mobile-menu-2" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1"
                        id="mobile-menu-2">
                        <ul
                            class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 rtl:space-x-reverse">
                            <li>
                                <a href="{{ url('/') }}" wire:navigate @class([
                                    'block py-2 pr-4 pl-3 rounded bg-red-700 lg:bg-transparent lg:p-0',
                                    'dark:text-white text-gray-700' => !request()->routeIs(['home']),
                                    'dark:text-skin-base text-skin-base' => request()->routeIs(['home']),
                                ])
                                    aria-current="page">@lang('menu.home')</a>
                            </li>


                            <li>
                                <a href="{{ url('/') }}#icon-features" @class([
                                    'transition-all duration-300 block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 text-gray-700 dark:text-white',
                                ])
                                    aria-current="page">@lang('landing.features')</a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#simple-pricing" @class([
                                    'transition-all duration-300 block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 text-gray-700 dark:text-white',
                                ])
                                    aria-current="page">@lang('landing.pricing')</a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#user-faqs" @class([
                                    'transition-all duration-300 block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 text-gray-700 dark:text-white',
                                ])
                                    aria-current="page">@lang('landing.faq')</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="flex mt-4 overflow-hidden  dark:bg-gray-900">
            <div id="main-content" class="w-full h-full overflow-y-auto dark:bg-gray-900">
                <main>

                    @yield('content')

                    {{ $slot ?? '' }}
                </main>
            </div>
        </div>

    </div>

    @stack('modals')

    <footer class="p-4 bg-white sm:p-6 dark:bg-gray-800 border-t ">
        <div class="mx-auto max-w-screen-xl">
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ now()->year }} <a
                        href="" class="hover:underline">{{ global_setting()->name }}</a>. @lang('landing.rightsReserved')
                </span>
                <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0 rtl:space-x-reverse">
                    @if (languages()->count() > 1)
                        @livewire('shop.languageSwitcher')
                    @endif

                    @if (global_setting()->facebook_link)
                        <a href="{{ global_setting()->facebook_link }}"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    @if (global_setting()->instagram_link)
                        <a href="{{ global_setting()->instagram_link }}"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    @if (global_setting()->twitter_link)
                        <a href="{{ global_setting()->twitter_link }}"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 50 50 " aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                                viewBox="0 0 50 50">
                                <path
                                    d="M 6.9199219 6 L 21.136719 26.726562 L 6.2285156 44 L 9.40625 44 L 22.544922 28.777344 L 32.986328 44 L 43 44 L 28.123047 22.3125 L 42.203125 6 L 39.027344 6 L 26.716797 20.261719 L 16.933594 6 L 6.9199219 6 z">
                                </path>
                            </svg>
                        </a>
                    @endif

                    @if (global_setting()->yelp_link)
                        <a href="{{ global_setting()->yelp_link }}"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 30 30" aria-hidden="true">
                                <path
                                    d="M13.961 22.279c0.246-0.273 0.601-0.444 0.995-0.444 0.739 0 1.338 0.599 1.338 1.338 0 0.016-0 0.032-0.001 0.048l0-0.002-0.237 6.483c-0.027 0.719-0.616 1.293-1.34 1.293-0.077 0-0.153-0.006-0.226-0.019l0.008 0.001c-1.763-0.303-3.331-0.962-4.69-1.902l0.039 0.025c-0.351-0.245-0.578-0.647-0.578-1.102 0-0.346 0.131-0.661 0.346-0.898l-0.001 0.001 4.345-4.829zM12.853 20.434l-6.301 1.572c-0.097 0.025-0.208 0.039-0.322 0.039-0.687 0-1.253-0.517-1.332-1.183l-0.001-0.006c-0.046-0.389-0.073-0.839-0.073-1.295 0-1.324 0.223-2.597 0.635-3.781l-0.024 0.081c0.183-0.534 0.681-0.911 1.267-0.911 0.214 0 0.417 0.050 0.596 0.14l-0.008-0.004 5.833 2.848c0.45 0.221 0.754 0.677 0.754 1.203 0 0.623-0.427 1.147-1.004 1.294l-0.009 0.002zM13.924 15.223l-6.104-10.574c-0.112-0.191-0.178-0.421-0.178-0.667 0-0.529 0.307-0.987 0.752-1.204l0.008-0.003c1.918-0.938 4.153-1.568 6.511-1.761l0.067-0.004c0.031-0.003 0.067-0.004 0.104-0.004 0.738 0 1.337 0.599 1.337 1.337 0 0.001 0 0.001 0 0.002v-0 12.207c-0 0.739-0.599 1.338-1.338 1.338-0.493 0-0.923-0.266-1.155-0.663l-0.003-0.006zM19.918 20.681l6.176 2.007c0.541 0.18 0.925 0.682 0.925 1.274 0 0.209-0.048 0.407-0.134 0.584l0.003-0.008c-0.758 1.569-1.799 2.889-3.068 3.945l-0.019 0.015c-0.23 0.19-0.527 0.306-0.852 0.306-0.477 0-0.896-0.249-1.134-0.625l-0.003-0.006-3.449-5.51c-0.128-0.201-0.203-0.446-0.203-0.709 0-0.738 0.598-1.336 1.336-1.336 0.147 0 0.289 0.024 0.421 0.068l-0.009-0.003zM26.197 16.742l-6.242 1.791c-0.11 0.033-0.237 0.052-0.368 0.052-0.737 0-1.335-0.598-1.335-1.335 0-0.282 0.087-0.543 0.236-0.758l-0.003 0.004 3.63-5.383c0.244-0.358 0.65-0.59 1.111-0.59 0.339 0 0.649 0.126 0.885 0.334l-0.001-0.001c1.25 1.104 2.25 2.459 2.925 3.99l0.029 0.073c0.070 0.158 0.111 0.342 0.111 0.535 0 0.608-0.405 1.121-0.959 1.286l-0.009 0.002z">
                                </path>
                            </svg>
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </footer>
    @livewireScripts
    @include('layouts.update-uri')
    <x-livewire-alert::flash />
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
            navigator.serviceWorker.register('{{ asset('service-worker.js') }}')
                .then(registration => {
                console.log('Service Worker registered:', registration);
                })
                .catch(error => {
                console.log('Service Worker registration failed:', error);
                });
            });
        }
     </script>
     <script>

        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            deferredPrompt = event;
            setTimeout(() => {
                const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
                if (isMobile) {
                    deferredPrompt.prompt(); // This triggers the install prompt
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the A2HS prompt');
                        } else {
                            console.log('User dismissed the A2HS prompt');
                        }
                        deferredPrompt = null;
                    });
                }
            }, 1000);
        });

     </script>
    @stack('scripts')
</body>

</html>
