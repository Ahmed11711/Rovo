<div>
    <aside id="sidebar"
        class="fixed top-0 ltr:left-0 rtl:right-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
        aria-label="Sidebar">
        <div
            class="relative flex flex-col flex-1 min-h-0 pt-0 bg-gray-50 border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
                <div
                    class="flex-1 px-3 space-y-1 bg-gray-50 divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                    <ul class="py-2 space-y-2">


                        @livewire('sidebar-menu-item', ['name' => __('menu.dashboard'), 'icon' => 'dashboard', 'link' => route('superadmin.dashboard'), 'active' => request()->routeIs('superadmin.dashboard')])

                        @livewire('sidebar-menu-item', ['name' => __('superadmin.menu.restaurants'), 'icon' => 'restaurants', 'link' => route('superadmin.restaurants.index'), 'active' => request()->routeIs('superadmin.restaurants.*')])

                        @livewire('sidebar-menu-item', ['name' => __('menu.payments'), 'icon' => 'payments', 'link' => route('superadmin.restaurant-payments.index'), 'active' => request()->routeIs('superadmin.restaurant-payments.index')])

                        @livewire('sidebar-menu-item', ['name' => __('menu.packages'), 'icon' => 'packages', 'link' => route('superadmin.packages.index'), 'active' => request()->routeIs('superadmin.packages.*')])

                        @livewire('sidebar-menu-item', ['name' => __('menu.billing'), 'icon' => 'billing', 'link' => route('superadmin.invoices.index'), 'active' => request()->routeIs('superadmin.invoices.*')])

                        @livewire('sidebar-menu-item', ['name' => __('menu.offlineRequest'), 'icon' => 'offline-plan-request', 'link' => route('superadmin.offline-plan-request'), 'active' => request()->routeIs('superadmin.offline-plan-request')])

                        @livewire('sidebar-menu-item', ['name' => __('menu.landingSites'), 'icon' => 'landing', 'link' => route('superadmin.landing-sites.index'), 'active' => request()->routeIs('superadmin.landing-sites.*')])

                        @livewire('sidebar-menu-item', ['name' => __('menu.settings'), 'icon' => 'settings', 'link' => route('superadmin.superadmin-settings.index'), 'active' => request()->routeIs('superadmin.superadmin-settings.index')])

                    </ul>

                </div>
            </div>


        </div>
    </aside>

    <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>


</div>
