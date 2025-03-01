
<header class="lg:hidden">
    <nav class="bg-white border-gray-200 px-4 py-2.5 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto">
            <a href="{{ module_enabled('Subdomain')?url('/'):route('shop_restaurant',['hash' => $restaurant->hash]).'?branch=' . $shopBranch->id }}" class="flex items-center">
                <img src="{{ $restaurant->logoUrl }}" class="ltr:mr-3 rtl:ml-3 h-6 sm:h-9" alt="App Logo" />
                @if ($restaurant->show_logo_text)
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ $restaurant->name }}</span>
                @endif
            </a>


            <div class="flex items-center">
                <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <div class="hidden justify-between items-center w-full bg-gray-50 mt-4 rounded-md dark:bg-gray-800" id="mobile-menu-2">
                <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                    @livewire('forms.shopSelectBranchMobile', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch])
                </div>
                <ul class="flex flex-col font-medium ">
                    @if ($restaurant->allow_customer_orders)
                    <li>
                        <a href="{{ module_enabled('Subdomain')?url('/'):route('shop_restaurant', [$restaurant->hash]) }}" wire:navigate class="block py-2 pr-4 pl-3 text-gray-700 rounded   dark:text-white dark:hover:bg-gray-700 dark:hover:text-white dark:bg-gray-700" >@lang('menu.newOrder')</a>
                    </li>
                    @endif
                    @if (in_array('Table Reservation', $modules))
                    <li>
                        <a href="{{ route('book_a_table', [$restaurant->hash]).'?branch=' . $shopBranch->id }}" wire:navigate class="block py-2 pr-4 pl-3 text-gray-700 rounded dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:bg-gray-800" >@lang('menu.bookTable')</a>
                    </li>
                    @endif
                    @if (!is_null(customer()))
                    <li>
                        <a href="{{ route('my_orders', [$restaurant->hash]).'?branch=' . $shopBranch->id }}" wire:navigate class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50  dark:text-gray-400  dark:hover:bg-gray-700 dark:hover:text-white  dark:border-gray-700 ">@lang('menu.myOrders')</a>
                    </li>

                    @if (in_array('Table Reservation', $modules))
                    <li>
                        <a href="{{ route('my_bookings', [$restaurant->hash]).'?branch=' . $shopBranch->id }}" wire:navigate class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50  dark:text-gray-400  dark:hover:bg-gray-700 dark:hover:text-white  dark:border-gray-700">@lang('menu.myBookings')</a>
                    </li>
                    @endif

                    <li>
                        <a href="{{ route('profile', [$restaurant->hash]).'?branch=' . $shopBranch->id }}" wire:navigate class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50  dark:text-gray-400  dark:hover:bg-gray-700 dark:hover:text-white  dark:border-gray-700">@lang('menu.profile')</a>
                    </li>

                    <li>
                        <a href="{{ url('customer-logout') }}" class="block py-2 pr-4 pl-3 text-gray-700 rounded   dark:text-white dark:hover:bg-gray-700 dark:hover:text-white dark:bg-gray-700" >@lang('app.logout')</a>
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
</header>
