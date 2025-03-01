<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">

      <div class="flex items-center justify-start">
        <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
          class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
          <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
              clip-rule="evenodd"></path>
          </svg>
          <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
        <a href="{{ route('dashboard') }}" class="flex ltr:ml-2 rtl:mr-2 items-center">
          <img src="{{ restaurant()->logoUrl }}" class="h-8 ltr:mr-3 rtl:ml-3" alt="" />

          @if (restaurant()->show_logo_text)
          <span class="self-center text-xl font-semibold sm:text-xl whitespace-nowrap dark:text-white hidden lg:block ltr:mr-2 rtl:ml-2">{{ Str::limit(restaurant()->name, 10) }}</span>
          @endif
        </a>

        <button id="toggle-sidebar" type="button" class="lg:inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 mx-2 hidden">
          <!-- Menu expand icon (shows when sidebar is collapsed) -->
          <svg id="toggle-sidebar-open" class="hidden w-6 h-6 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
          </svg>
          <!-- Menu collapse icon (shows when sidebar is expanded) -->
          <svg id="toggle-sidebar-close" class=" w-6 h-6 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M19 19l-7-7 7-7"/>
          </svg>
      </button>

        <div class="flex gap-2">
          @if (in_array('Order', restaurant_modules()) && user_can('Show Order') && restaurant()->hide_new_orders == 0)
            @livewire('dashboard.todayOrders')
          @endif

          @if (in_array('Reservation', restaurant_modules()) && user_can('Show Reservation') && restaurant()->hide_new_reservations == 0 && in_array('Table Reservation', restaurant_modules()))
            @livewire('dashboard.todayReservations')
          @endif

          @if (in_array('Waiter Request', restaurant_modules()) && user_can('Manage Waiter Request') && restaurant()->hide_new_waiter_request == 0)
            @livewire('dashboard.activeWaiterRequests')
          @endif

        </div>



      </div>

      <div class="flex items-center gap-4 w-fit justify-end">

        <!-- Search mobile -->
        <button id="toggleSidebarMobileSearch" type="button"
          class="p-2 text-gray-500 rounded-lg hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
          <span class="sr-only">Search</span>
          <!-- Search icon -->
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
              clip-rule="evenodd"></path>
          </svg>
        </button>


        @if (languages()->count() > 1)
         @livewire('settings.languageSwitcher')
        @endif


        @livewire('restaurant.stop-impersonate-restaurant')

        @if (restaurant()->package->package_type == \App\Enums\PackageType::DEFAULT)
            <a href="{{ route('pricing.plan') }}" wire:navigate class="hidden lg:inline-flex" >
                <x-secondary-button class="inline-flex items-center shadow-md text-skin-base dark:text-skin-base hover:origin-center group">
                    <svg class="w-5 h-5 text-current group-hover:scale-110 duration-500" width="24" height="24" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/></svg>
                    @lang('modules.settings.upgradeLicense')
                </x-secondary-button>
            </a>
        @elseif (restaurant()->package->package_type == \App\Enums\PackageType::TRIAL)
        <a href="{{ route('pricing.plan') }}" wire:navigate class="hidden xl:inline-flex" >
            <x-secondary-button>
                @php
                    $daysLeftInTrial = floor(now(timezone())->diffInDays(\Carbon\Carbon::parse(restaurant()->trial_ends_at)->addDays(1)));
                @endphp
                {{ $daysLeftInTrial > 0 ? $daysLeftInTrial .' ' . __('modules.package.daysLeftTrial') : __('modules.package.trialExpired') }}
            </x-secondary-button>
        </a>
        @endif

        <button onclick="openFullscreen();" type="button" data-tooltip-target="fullscreen-tooltip-toggle"
        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fullscreen" viewBox="0 0 16 16">
            <path d="M1.5 1a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4A1.5 1.5 0 0 1 1.5 0h4a.5.5 0 0 1 0 1zM10 .5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 16 1.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5M.5 10a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 0 14.5v-4a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v4a1.5 1.5 0 0 1-1.5 1.5h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5"/>
          </svg>
        </button>

        <div id="fullscreen-tooltip-toggle" role="tooltip"
          class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
          View in Fullscreen
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>

        <button id="theme-toggle" data-tooltip-target="tooltip-toggle" type="button"
          class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
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
          class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
          Toggle dark mode
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>


        <!-- Profile -->
        <div class="flex items-center w-8">
          <div class="flex w-full">
            <button type="button"
              class="inline-flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
              id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
              <span class="sr-only">Open user menu</span>
              <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profile_photo_path ? asset_url_local_s3(auth()->user()->profile_photo_path):auth()->user()->profile_photo_url }}" alt="user photo">
            </button>
          </div>
          <!-- Dropdown menu -->
          <div
            class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
            id="dropdown-2">
            <div class="px-4 py-3" role="none">
              <p class="text-sm text-gray-900 dark:text-white" role="none">
                {{ auth()->user()->name }}
              </p>
              <p class="text-sm font-medium text-gray-500 truncate dark:text-gray-300" role="none">
                {{ auth()->user()->email }}
              </p>
            </div>
            <ul class="py-1" role="none">
              <li>
                <a href="{{ route('profile.show') }}" wire:navigate
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                  role="menuitem">@lang('menu.profile')</a>
              </li>

              @if (user_can('Manage Settings'))
              <li>
                <a href="{{ route('settings.index') }}" wire:navigate
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                  role="menuitem">@lang('menu.settings')</a>
              </li>

              {{-- <li>
                <a href="{{ route('app-update.index') }}"
                  class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                  role="menuitem">
                  @lang('menu.appUpdate')

                  <span class="bg-skin-base text-white text-xs font-medium px-1.5 py-0.5 rounded-full dark:bg-gray-500 dark:text-gray-300">v{{ \Illuminate\Support\Facades\File::get('version.txt') }}</span>
                </a>
              </li> --}}
              @endif

              <li>
                <form method="POST" action="{{ route('logout') }}" x-data>
                  @csrf
                  <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">@lang('menu.signOut')</a>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
