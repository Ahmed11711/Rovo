<div>
    <aside id="sidebar"
        class="fixed top-0 ltr:left-0 rtl:right-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width menu-collapsed:hidden"
        aria-label="Sidebar">
        <div
            class="relative flex flex-col flex-1 min-h-0 pt-0 bg-gray-50 ltr:border-r rtl:border-l border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto mb-16 [&::-webkit-scrollbar]:w-1.5
            [&::-webkit-scrollbar-track]:rounded-xl
            [&::-webkit-scrollbar-thumb]:rounded-xl
            [&::-webkit-scrollbar-track]:bg-gray-300
            [&::-webkit-scrollbar-thumb]:bg-gray-400
            hover:[&::-webkit-scrollbar-thumb]:bg-gray-500
            dark:[&::-webkit-scrollbar-track]:bg-gray-700
            dark:[&::-webkit-scrollbar-thumb]:bg-gray-500
            dark:hover:[&::-webkit-scrollbar-thumb]:bg-gray-400">
                <div
                    class="flex-1 px-3 space-y-1 bg-gray-50 divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                    @if (user()->hasRole('Admin_'.user()->restaurant_id))
                    @livewire('forms.change-branch')
                    @endif

                    <ul class="py-2 space-y-2">

                        @livewire('sidebar-menu-item', ['name' => __('menu.dashboard'), 'icon' => 'dashboard', 'link' => route('dashboard'), 'active' => request()->routeIs('dashboard')])

                        @if ($this->hasModule('Menu')  || $this->hasModule('Menu Item') || $this->hasModule('Item Category'))
                        @if (user_can('Show Menu') || user_can('Show Menu Item') || user_can('Show Item Category'))
                        <x-sidebar-dropdown-menu :name='__("menu.menu")' icon='menu' :active='request()->routeIs(["menus.*", "menu-items.*", "item-categories.*", "item-modifiers.*", "modifier-groups.*"])'>
                            @if($this->hasModule('Menu'))
                            @if(user_can('Show Menu'))
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.menus'), 'link' => route('menus.index'), 'active' => request()->routeIs('menus.index')])
                            @endif
                            @endif

                            @if($this->hasModule('Menu Item'))
                            @if(user_can('Show Menu Item'))
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.menuItem'), 'link' => route('menu-items.index'), 'active' => request()->routeIs('menu-items.index')])
                            @endif
                            @endif

                            @if($this->hasModule('Item Category'))
                            @if(user_can('Show Item Category'))
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.itemCategories'), 'link' => route('item-categories.index'), 'active' => request()->routeIs('item-categories.index')])
                            @endif
                            @endif

                            @if($this->hasModule('Menu Item'))
                            @if(user_can('Show Menu Item'))
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.modifierGroups'), 'link' => route('modifier-groups.index'), 'active' => request()->routeIs('modifier-groups.index')])
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.itemModifiers'), 'link' => route('item-modifiers.index'), 'active' => request()->routeIs('item-modifiers.index')])
                            @endif
                            @endif
                        </x-sidebar-dropdown-menu>
                        @endif
                        @endif

                        @if ($this->hasModule('Area') || $this->hasModule('Table'))
                        @if (user_can('Show Area') || user_can('Show Table'))
                        <x-sidebar-dropdown-menu :name='__("menu.tables")' icon='table' :active='request()->routeIs(["areas.*", "tables.*", "qrcodes.index"])'>
                            @if ($this->hasModule('Area'))
                            @if(user_can('Show Area'))
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.areas'), 'link' => route('areas.index'), 'active' => request()->routeIs('areas.index')])
                            @endif
                            @endif

                            @if ($this->hasModule('Table'))
                            @if(user_can('Show Table'))
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.tables'), 'link' => route('tables.index'), 'active' => request()->routeIs('tables.index')])
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.qrCodes'), 'link' => route('qrcodes.index'), 'active' => request()->routeIs('qrcodes.index')])
                            @endif
                            @endif

                        </x-sidebar-dropdown-menu>
                        @endif
                        @endif

                        @if ($this->hasModule('Waiter Request') && user_can('Manage Waiter Request'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.waiterRequest'), 'icon' => 'waiterRequest', 'link' => route('waiter-requests.index'), 'active' => request()->routeIs('waiter-requests.*')])
                        @endif

                        @if ($this->hasModule('Reservation') && user_can('Show Reservation'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.reservations'), 'icon' => 'reservations', 'link' => route('reservations.index'), 'active' => request()->routeIs('reservations.index')])
                        @endif

                        @if ($this->hasModule('Order') && user_can('Create Order'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.pos'), 'icon' => 'pos', 'link' => route('pos.index'), 'active' => request()->routeIs('pos.*')])
                        @endif

                        @if ($this->hasModule('Order') || $this->hasModule('KOT'))
                        @if (user_can('Show Order') || user_can('Manage KOT'))
                        <x-sidebar-dropdown-menu :name='__("menu.orders")' icon='orders' :active='request()->routeIs(["orders.*", "kots.*"])'>
                            @if($this->hasModule('KOT'))
                            @if (user_can('Manage KOT'))
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.kot'), 'link' => route('kots.index'), 'active' => request()->routeIs('kots.*')])
                            @endif
                            @endif

                            @if($this->hasModule('Order'))
                            @if (user_can('Show Order'))
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.orders'), 'link' => route('orders.index'), 'active' => request()->routeIs('orders.*')])
                            @endif
                            @endif
                        </x-sidebar-dropdown-menu>
                        @endif
                        @endif

                        @if($this->hasModule('Customer'))
                        @if (user_can('Show Customer'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.customers'), 'icon' => 'customers', 'link' => route('customers.index'), 'active' => request()->routeIs('customers.index')])
                        @endif
                        @endif
                        @if($this->hasModule('Staff'))
                        @if (user_can('Show Staff Member'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.staff'), 'icon' => 'staff', 'link' => route('staff.index'), 'active' => request()->routeIs('staff.index')])
                        @endif
                        @endif
                        @if($this->hasModule('Delivery Executive'))
                        @if (user_can('Show Delivery Executive'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.deliveryExecutive'), 'icon' => 'delivery', 'link' => route('delivery-executives.index'), 'active' => request()->routeIs('delivery-executives.index')])
                        @endif
                        @endif

                        @if ($this->hasModule('Payment'))
                        @if (user_can('Show Payments'))
                        <x-sidebar-dropdown-menu :name='__("menu.payments")' icon='payments' :active='request()->routeIs(["payments.*"])'>
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.payments'), 'link' => route('payments.index'), 'active' => request()->routeIs('payments.index')])
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.duePayments'), 'link' => route('payments.due'), 'active' => request()->routeIs('payments.due')])
                        </x-sidebar-dropdown-menu>
                        @endif
                        @endif
                        @if ($this->hasModule('Report'))
                        @if (user_can('Show Reports'))
                        <x-sidebar-dropdown-menu :name='__("menu.reports")' icon='reports' :active='request()->routeIs(["reports.*"])'>
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.salesReport'), 'link' => route('reports.sales'), 'active' => request()->routeIs('reports.sales')])
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.itemReport'), 'link' => route('reports.item'), 'active' => request()->routeIs('reports.item')])
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.categoryReport'), 'link' => route('reports.category'), 'active' => request()->routeIs('reports.category')])
                        </x-sidebar-dropdown-menu>
                        @endif
                        @endif

                        @foreach (custom_module_plugins() as $item)
                            @includeIf(strtolower($item) . '::sections..sidebar')
                        @endforeach

                        @if($this->hasModule('Settings'))
                        @if (user_can('Manage Settings'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.settings'), 'icon' => 'settings', 'link' => route('settings.index'), 'active' => request()->routeIs('settings.index')])
                        @endif
                        @endif


                        @livewire('sidebar-menu-item', [
                            'name' => __('bundle'),
                            'icon' => 'fa-box',
                            'link' => route('bundle'),
                            'active' => request()->routeIs('bundle')
                        ])
                    </ul>

                </div>
            </div>


            <div class="absolute bottom-0 left-0 justify-center hidden w-full p-2 space-x-4 bg-white lg:flex dark:bg-gray-800 rtl:space-x-reverse" sidebar-bottom-menu>
                <a href="{{ module_enabled('Subdomain')?url('/'):route('shop_restaurant', [restaurant()->hash]) }}" target="_blank" class="inline-flex justify-center items-center gap-1 p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                    @lang('menu.customerSite')

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5"/>
                        <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z"/>
                    </svg>
                </a>

            </div>
        </div>
    </aside>

    <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>


</div>
