<header class="hidden lg:block z-50">
    <nav class="bg-white border-gray-200 px-4 py-2.5 dark:bg-gray-800 sticky top-4 rounded-md mt-2 ">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <div class="flex gap-8 items-center">
                <a href="{{ module_enabled('Subdomain') ? url('/') : route('shop_restaurant', ['hash' => $restaurant->hash]) }}"
                    class="inline-flex items-center">
                    <img src="{{ $restaurant->logoUrl }}" class="ltr:mr-3 rtl:ml-3 h-6 sm:h-9" alt="App Logo" />
                    @if ($restaurant->show_logo_text)
                        <span
                            class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ $restaurant->name }}</span>
                    @endif
                </a>

                @livewire('forms.shopSelectBranch', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch])


                <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">

                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 rtl:space-x-reverse">
                        <li>
                            <a href="{{ module_enabled('Subdomain') ? url('/') : route('shop_restaurant', [$restaurant->hash]) . '?branch=' . $shopBranch->id }}"
                                wire:navigate @class([
                                    'block py-2 pr-4 pl-3 rounded bg-primary-700 lg:bg-transparent lg:p-0',
                                    'dark:text-white text-gray-700' => !request()->routeIs(['home']),
                                    'dark:text-skin-base text-skin-base' => request()->routeIs(['home']),
                                ]) aria-current="page">@lang('menu.home')</a>
                        </li>

                        @if (in_array('Table Reservation', $modules))
                            <li>
                                <a href="{{ route('book_a_table', [$restaurant->hash]) . '?branch=' . $shopBranch->id }}"
                                    wire:navigate @class([
                                        'block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0',
                                        'text-gray-700 dark:text-white' => !request()->routeIs(['book_a_table']),
                                        'dark:text-skin-base text-skin-base' => request()->routeIs([
                                            'book_a_table',
                                        ]),
                                    ]) aria-current="page">@lang('menu.bookTable')</a>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('about', [$restaurant->hash]) . '?branch=' . $shopBranch->id }}"
                                wire:navigate @class([
                                    'block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0',
                                    'text-gray-700 dark:text-white' => !request()->routeIs(['about']),
                                    'dark:text-skin-base text-skin-base' => request()->routeIs(['about']),
                                ]) aria-current="page">@lang('menu.about', [$restaurant->hash])</a>
                        </li>
                        <li>
                            <a href="{{ route('contact', [$restaurant->hash]) . '?branch=' . $shopBranch->id }}"
                                wire:navigate @class([
                                    'block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0',
                                    'text-gray-700 dark:text-white' => !request()->routeIs(['contact']),
                                    'dark:text-skin-base text-skin-base' => request()->routeIs(['contact']),
                                ]) aria-current="page">@lang('menu.contact', [$restaurant->hash])</a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="flex items-center lg:order-2 gap-1">

                {{-- @if ($restaurant->is_waiter_request_enabled)
                    @livewire('forms.callWaiterButton', ['tableNumber' => $table->id ?? null, 'shopBranch' => $shopBranch])
                @endif --}}

                @if ($this->shouldShowWaiterButton)
                    @livewire('forms.callWaiterButton', ['tableNumber' => $table->id ?? null, 'shopBranch' => $shopBranch])
                @endif


                <button id="theme-toggle" data-tooltip-target="tooltip-toggle" type="button"
                    class=" text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
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


                <a href="javascript:;" wire:click="$dispatch('showCartItems')"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
                        class="bi bi-cart2" viewBox="0 0 16 16">
                        <path
                            d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                    </svg>
                    @if (isset($orderItemCount) && $orderItemCount > 0)
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-skin-base border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                            {{ $orderItemCount }}</div>
                    @endif
                </a>

                @if (is_null(customer()) && $restaurant->customer_login_required)
                    <x-button type="button" wire:click="$dispatch('showSignup')">@lang('app.login')</x-button>
                @endif

                @if (!is_null(customer()))
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                        class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-skin-base md:p-0 md:w-auto dark:text-white md:dark:hover:text-skin-base dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">@lang('menu.myAccount')
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbar"
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="{{ route('profile', [$restaurant->hash]) }}" wire:navigate
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">@lang('menu.profile')</a>
                            </li>
                            <li>
                                <a href="{{ route('my_orders', [$restaurant->hash]) }}" wire:navigate
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">@lang('menu.myOrders')</a>
                            </li>
                            @if (in_array('Table Reservation', $modules))
                                <li>
                                    <a href="{{ route('my_bookings', [$restaurant->hash]) }}" wire:navigate
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">@lang('menu.myBookings')</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('customer-logout') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">@lang('app.logout')</a>
                            </li>
                        </ul>

                    </div>
                @endif

                <button data-collapse-toggle="mobile-menu-2" type="button"
                    class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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

        </div>
    </nav>
</header>
