<div>

    @if ($showFilters)
        @include('menu_items.filters')
    @endif

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.itemName')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.setPrice')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.itemCategory')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.menuName')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.isAvailable')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='menu-item-list-{{ microtime() }}'>

                            @forelse ($menuItems as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='menu-item-{{ $item->id . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <td class="lg:flex items-center p-4 mr-12 lg:space-x-6 rtl:space-x-reverse">
                                    <img class="w-12 h-12 lg:w-16 lg:h-16 rounded-md object-cover" src="{{ $item->item_photo_url }}"
                                        alt="{{ $item->item_name }}">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400 w-40 lg:w-auto">
                                        <div class="text-sm lg:text-base font-semibold text-gray-900 dark:text-white inline-flex items-center">
                                            <img src="{{ asset('img/'.$item->type.'.svg')}}" class="h-4 mr-2" title="@lang('modules.menu.' . $item->type)" alt="" />
                                            {{ $item->item_name }}

                                            @if (!$item->is_available)
                                                <span class="text-xs font-medium ms-2 px-1.5 py-0.5 rounded-full bg-red-200 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                    @lang('app.inactive')
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                                            $item->description }}</div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->price ? currency_format($item->price) : '--' }}
                                </td>

                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">{{
                                    $item->category->category_name }}</td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">{{
                                    $item->menu->menu_name }}</td>
                                <td class="py-2.5 px-4 text-center text-gray-900 whitespace-nowrap dark:text-white">
                                    <x-checkbox name="isRecommended" id="isRecommended" wire:click="toggleAvailability({{ $item->id }})" wire:key="itemAvailability-{{ $item->id }}" :checked="(bool) $item->is_available" />
                                </td>
                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right rtl:space-x-reverse">
                                    @if ($item->variations_count > 0)
                                    <x-secondary-button-table wire:click='showItemVariations({{ $item->id }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="w-4 h-4 mr-1" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                        </svg>
                                        @lang('modules.menu.showVariations')
                                    </x-secondary-button-table>
                                    @endif

                                    @if(user_can('Update Menu Item'))
                                    <x-secondary-button-table wire:click='showEditMenu({{ $item->id }})'
                                        wire:key='editmenu-item-button-{{ $item->id }}'>
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
                                    </x-secondary-button>
                                    @endif

                                    @if(user_can('Delete Menu Item'))
                                    <x-danger-button-table wire:click="showDeleteMenuItem({{ $item->id }})">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </x-danger-button-table>
                                    @endif

                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 space-x-6" colspan="6">
                                    @lang('messages.noItemAdded')
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div wire:key='menu-item-paginate-{{ microtime() }}'
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0 w-full">
            {{ $menuItems->links() }}
        </div>
    </div>


    <!-- Product Drawer -->
    <x-right-modal wire:model.live="showEditMenuItem">
        <x-slot name="title">
            {{ __("modules.menu.editMenuItem") }}
        </x-slot>

        <x-slot name="content">
            @if ($menuItem)
            @livewire('forms.editMenuItem', ['menuItem' => $menuItem], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditMenuItem', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-dialog-modal wire:model.live="showMenuCategoryModal" maxWidth="xl">
        <x-slot name="title">
            @lang('modules.menu.itemCategory')
        </x-slot>

        <x-slot name="content">
            @livewire('forms.addItemCategory')
        </x-slot>

        <x-slot name="footer">
            <x-button-cancel wire:click="$toggle('showMenuCategoryModal')" wire:loading.attr="disabled" />
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="showItemVariationsModal" maxWidth="xl">
        <x-slot name="title">
            @lang('modules.menu.itemVariations')
        </x-slot>

        <x-slot name="content">
            @if ($menuItem)
            @livewire('menu.itemVariations', ['menuItem' => $menuItem], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-button-cancel wire:click="$toggle('showItemVariationsModal')" wire:loading.attr="disabled" />
        </x-slot>
    </x-dialog-modal>

    <x-confirmation-modal wire:model="confirmDeleteMenuItem">
        <x-slot name="title">
            @lang('modules.menu.deleteMenuItem')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.menu.deleteMenuItemMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteMenuItem')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($menuItem)
            <x-danger-button class="ml-3" wire:click='deleteMenuItem({{ $menuItem->id }})' wire:loading.attr="disabled" wire:key="delete-menu-item-{{ $menuItem->id }}">
                {{ __('Delete') }}
            </x-danger-button>
            @endif
        </x-slot>
    </x-confirmation-modal>

</div>
