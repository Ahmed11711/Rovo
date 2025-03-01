<div>
    <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('modules.menu.allMenus')</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="products-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <x-input id="menu_name" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.searchMenus') }}" wire:model.live.debounce.500ms="search" />

                        </div>
                    </form>
                </div>

                @if(user_can('Create Menu'))
                <x-button type='button' data-drawer-target="drawer-create-product-default" data-drawer-show="drawer-create-product-default" aria-controls="drawer-create-product-default" data-drawer-placement="right" id="createProductButton">@lang('modules.menu.addMenu')</x-button>
                @endif
            </div>
        </div>
    </div>

    <div class="flex flex-col my-4 px-4">
        <!-- Card Section -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @forelse ($menus as $item)
            <!-- Card -->
            <a
            @class(['group flex flex-col border shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600', 'bg-skin-base' => ($menuId == $item->id), 'bg-white' => ($menuId != $item->id)])
            wire:key='menu-{{ $item->id . microtime() }}' wire:click='showMenuItems({{ $item->id }})'
                href="javascript:;">
                <div class="p-3">
                    <div class="flex items-center">
                        <div class="bg-gray-100 p-2 rounded-md">

                            <svg class="flex-shrink-0 size-5 text-gray-800 dark:text-neutral-200" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.221 409.221" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 409.221 409.221">
                                <path d="m387.059,389.218h-14.329v-18.114h14.327c5.523,0 10-4.477 10-10 0-55.795-42.81-101.781-97.305-106.843v-17.29c0-5.523-4.477-10-10-10s-10,4.477-10,10v17.29c-54.496,5.062-97.305,51.048-97.305,106.843 0,5.523 4.477,10 10,10h14.327v18.114h-14.327c-5.523,0-10,4.477-10,10s4.477,10 10,10h24.13c0.131,0.003 0.262,0.003 0.393,0h145.564c0.065,0.001 0.131,0.002 0.196,0.002s0.131,0 0.196-0.002h24.133c5.523,0 10-4.477 10-10s-4.478-10-10-10zm-34.33,0h-125.957v-18.114h125.957v18.114zm-149.714-38.113c4.978-43.447 41.978-77.305 86.736-77.305s81.758,33.858 86.736,77.305h-173.472zm-71.385-253.799c-29.383,1.42109e-14-52.4,16.809-52.4,38.267 0,21.457 23.017,38.265 52.4,38.265 29.383,0 52.399-16.808 52.399-38.265 0-21.459-23.016-38.267-52.399-38.267zm0,56.531c-19.094,0-32.4-9.625-32.4-18.265 0-8.64 13.306-18.267 32.4-18.267 19.093,0 32.399,9.627 32.399,18.267 0,8.639-13.306,18.265-32.399,18.265zm23.553,235.383h-123.021v-320.568h198.936v166.52c0,5.523 4.477,10 10,10s10-4.477 10-10v-176.52c0-5.523-4.477-10-10-10h-4.701v-38.652c0-2.858-1.223-5.58-3.36-7.478-2.137-1.897-4.984-2.789-7.822-2.452l-204.236,24.327c-5.03,0.599-8.817,4.864-8.817,9.93v364.893c0,5.523 4.477,10 10,10h133.021c5.523,0 10-4.477 10-10s-4.477-10-10-10zm-123.021-346.014l184.235-21.944v27.391h-184.235v-5.447zm82.627,317.362c-5.523,0-10-4.477-10-10s4.477-10 10-10h33.681c5.523,0 10,4.477 10,10s-4.477,10-10,10h-33.681z"/>
                            </svg>

                        </div>

                        <div class="grow ms-5">
                            <h3 wire:loading.class.delay='opacity-50'
                                @class(['font-semibold dark:group-hover:text-neutral-400 dark:text-neutral-200', 'text-gray-800 group-hover:text-skin-base' => ($menuId != $item->id), 'text-white group-hover:text-white' => ($menuId == $item->id)])>
                                {{ $item->menu_name }}
                            </h3>
                            <p
                            @class(['text-sm dark:text-neutral-500', 'text-gray-500' => ($menuId != $item->id), 'text-gray-100' => ($menuId == $item->id)])>
                                {{ $item->items_count }} @lang('modules.menu.item')
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            @empty
                <span class="dark:text-gray-400">@lang('messages.noMenuAdded')</span>
            @endforelse

        </div>
        <!-- End Card Section -->


        @if ($menuItems)
        <div class="w-full">
            <div class="my-4 flex items-center gap-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ $activeMenu->menu_name }}</h1>

                @if(user_can('Update Menu'))
                <x-secondary-button-table wire:click='showEditMenu({{ $activeMenu->id }})'
                    wire:key='editmenu-button-{{ $activeMenu->id }}'>
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                        </path>
                        <path fill-rule="evenodd"
                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                            clip-rule="evenodd"></path>
                    </svg>
                    @lang('app.update')
                </x-secondary-button-table>
                @endif

                @if(user_can('Delete Menu'))
                <x-danger-button-table wire:click="$toggle('confirmDeleteMenuModal')">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </x-danger-button-table>
                @endif

            </div>
        </div>

            @if(user_can('Show Menu Item'))
            <livewire:menu.menu-items :menuID='$menuId' key='menu-item-{{ microtime() }}' />
            @endif
        @endif
    </div>


    @if ($activeMenu)
    <x-right-modal wire:model.live="showEditMenuModal">
        <x-slot name="title">
            {{ __("modules.menu.editMenuItem") }}
        </x-slot>

        <x-slot name="content">
            @if ($activeMenu)
            @livewire('forms.editMenu', ['activeMenu' => $activeMenu], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditMenuModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-confirmation-modal wire:model="confirmDeleteMenuModal">
        <x-slot name="title">
            @lang('modules.menu.deleteMenu')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.menu.deleteMenuMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteMenuModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click='deleteMenu({{ $activeMenu->id }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
    @endif

</div>
