<div>
    <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.itemModifiers')</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="products-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <x-input id="menu_name" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.searchItemCategory') }}" wire:model.live.debounce.500ms="search" />

                        </div>
                    </form>
                </div>

                @if(user_can('Create Item Category'))
                <x-button type='button' wire:click="showAddItemModifierModal">@lang('modules.modifier.addItemModifier')</x-button>
                @endif

            </div>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">@lang('modules.menu.itemName')</th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">@lang('modules.modifier.modifierGroup')</th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">@lang('modules.modifier.isRequired')</th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">@lang('modules.modifier.allowMultipleSelection')</th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">@lang('app.action')</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($itemModifiers as $modifier)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $modifier->menuItem->item_name }}
                                    @if (!$modifier->menuItem->is_available)
                                        <span class="text-xs font-medium ms-0.5 px-1.5 py-0.5 rounded-full bg-red-200 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            @lang('app.inactive')
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">{{ $modifier->modifierGroup->name }}</td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    <span class="px-2 py-1 text-xs font-medium rounded {{ $modifier->is_required ? 'text-white bg-red-500' : 'text-gray-600 bg-gray-200' }}">
                                        @lang($modifier->is_required ? 'modules.modifier.required' : 'modules.modifier.optional')
                                    </span>
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    <span class="px-2 py-1 text-xs font-medium rounded {{ $modifier->allow_multiple_selection ? 'text-white bg-green-500' : 'text-gray-600 bg-gray-200' }}">
                                        @lang($modifier->allow_multiple_selection ? 'app.yes' : 'app.no')
                                    </span>
                                </td>
                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right">
                                    <x-secondary-button-table wire:click='showEditItemModifierModal({{ $modifier->id }})'
                                        wire:key='edit-cat-button-{{ $modifier->id }}'>
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 0 0-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 0 0 0-2.828"/><path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h4a1 1 0 0 1 0 2H4v10h10v-4a1 1 0 1 1 2 0v4a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z" clip-rule="evenodd"/></svg>
                                        @lang('app.update')
                                    </x-secondary-button-table>

                                    <x-danger-button-table wire:click="showDeleteModifier({{ $modifier->id }})">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 0 0-.894.553L7.382 4H4a1 1 0 0 0 0 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6a1 1 0 1 0 0-2h-3.382l-.724-1.447A1 1 0 0 0 11 2zM7 8a1 1 0 0 1 2 0v6a1 1 0 1 1-2 0zm5-1a1 1 0 0 0-1 1v6a1 1 0 1 0 2 0V8a1 1 0 0 0-1-1" clip-rule="evenodd"/></svg>
                                    </x-danger-button-table>
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 space-x-6 dark:text-gray-400" colspan="8">
                                    @lang('messages.noItemModifierFound')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div wire:key='item-modifier-paginate-{{ microtime() }}'
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0 w-full">
            {{ $itemModifiers->links() }}
        </div>
    </div>

   <x-right-modal wire:model.live="addItemModifierModal">
        <x-slot name="title">
            {{ __('modules.modifier.addItemModifier') }}
        </x-slot>

        <x-slot name="content">
            @if ($addItemModifierModal)
            @livewire('forms.addItemModifier')
            @endif
        </x-slot>
    </x-right-modal>

    <x-right-modal wire:model.live="editItemModifierModal">
        <x-slot name="title">
            {{ __("modules.modifier.updateItemModifier") }}
        </x-slot>

        <x-slot name="content">
            @if ($modifierGroupId)
            @livewire('forms.editItemModifier', ['itemModifierId' => $modifierGroupId], key(Str::random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('editItemModifierModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-confirmation-modal wire:model="confirmDeleteModifierModal">
        <x-slot name="title">
            @lang('modules.modifier.deleteItemModifier')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.modifier.deleteItemModifierMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteModifierModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if ($modifierGroupId)
            <x-danger-button class="ml-3" wire:click='deleteItemModifier({{ $modifierGroupId }})' wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
            @endif
        </x-slot>
    </x-confirmation-modal>

</div>
