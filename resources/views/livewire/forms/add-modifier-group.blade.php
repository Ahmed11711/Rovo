<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
            <!-- Modifier Group name and description -->
            <div>
                <x-label for="name" :value="__('modules.modifier.modifierName')" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" placeholder="{{ __('placeholders.modifierGroupNamePlaceholder') }}" />
                <x-input-error for="name" class="mt-2" />
            </div>

            <div>
                <x-label for="description" :value="__('modules.modifier.description')" />
                <x-textarea id="description" class="mt-1 block w-full" wire:model="description" data-gramm="false" placeholder="{{ __('placeholders.modifierGroupDescriptionPlaceholder') }}"></x-textarea>
                <x-input-error for="description" class="mt-2" />
            </div>

            <!-- Modifier Options Section -->
            <div class="col-span-2">
                <x-label :value="__('modules.modifier.modifierOptions')" />
                <div class="space-y-4 mt-1">
                    @foreach($modifierOptions as $index => $modifierOption)
                    <div wire:key="modifierOption-{{ $modifierOption['id'] }}" class="border p-3 flex items-baseline gap-x-4 justify-baseline rounded-lg dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                            <div>
                                <x-label for="modifierOptions.{{ $index }}.name" :value="__('modules.modifier.name')" />
                                <x-input id="modifierOptions.{{ $index }}.name" type="text" class="mt-1 block w-full"
                                    wire:model="modifierOptions.{{ $index }}.name" placeholder="{{ __('placeholders.modifierOptionNamePlaceholder') }}" />
                                <x-input-error for="modifierOptions.{{ $index }}.name" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="modifierOptions.{{ $index }}.price" :value="__('modules.modifier.price')" />
                                <x-input id="modifierOptions.{{ $index }}.price" type="number" step="0.001" class="mt-1 block w-full"
                                    wire:model="modifierOptions.{{ $index }}.price" placeholder="{{ __('placeholders.modifierOptionPricePlaceholder') }}" />
                                <x-input-error for="modifierOptions.{{ $index }}.price" class="mt-2" />
                            </div>

                            <x-label for="modifierOptions.{{ $index }}.is_available">
                                <div class="flex items-center cursor-pointer">
                                    <x-checkbox id="modifierOptions.{{ $index }}.is_available" wire:model="modifierOptions.{{ $index }}.is_available" value="{{ $modifierOption['id'] }}" />
                                    <div class="select-none ms-2">
                                        {{ __('modules.modifier.isAvailable') }}
                                    </div>
                                </div>
                            </x-label>
                        </div>

                        <div class="text-right">
                            <button type="button" class="bg-red-200 text-red-500 hover:bg-red-300 p-2 rounded" wire:click="removeModifierOption({{ $index }})">
                                <svg class="w-4 h-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L17.94 6M18 18L6.06 6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <x-secondary-button type="button" wire:click="addModifierOption">{{ __('modules.modifier.addModifierOption') }}</x-secondary-button>
                </div>
            </div>
            <!-- New Locations Section -->
            <div class="col-span-2">
                <x-label :value="__('modules.modifier.locations')" />
                <div x-data="{ isOpen: @entangle('isOpen').live , selectedMenuItems: @entangle('selectedMenuItems') }" @click.away="isOpen = false">
                    <div class="relative">
                        <div @click="isOpen = !isOpen"
                             class="p-2 bg-gray-100 border rounded cursor-pointer dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-600 dark:focus:ring-gray-600">
                            <div class="flex flex-wrap gap-2">
                                @forelse ($allMenuItems->whereIn('id', $selectedMenuItems) as $item)
                                    <span class="px-2 py-0.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 flex items-center" wire:key="selected-menu-item-{{ $item->id }}" @click.stop>
                                        {{ $item->item_name }}
                                        <button type="button" wire:click="toggleSelectItem({ id: {{ $item->id }}, item_name: '{{ addslashes($item->item_name) }}' })" class="inline-flex items-center p-1 ms-2 text-sm text-red-500 bg-transparent rounded-xs hover:bg-red-200 hover:text-red-900 dark:hover:bg-red-800 dark:hover:text-red-300">
                                            <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Remove badge</span>
                                        </button>
                                    </span>
                                @empty
                                {{ __('modules.modifier.selectMenuItem') }}
                                @endforelse
                            </div>
                        </div>

                        <!-- Search Input -->
                        <ul x-show="isOpen" x-transition class="absolute z-10 w-full mt-1 overflow-auto bg-white rounded-lg shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-600 dark:focus:ring-gray-600">
                            <li class="sticky top-0 px-3 py-2 bg-white dark:bg-gray-900 z-10">
                                <x-input wire:model.live.debounce.300ms="search" class="block w-full" type="text" placeholder="{{ __('placeholders.searchMenuItem') }}" />
                            </li>
                            @forelse ($menuItems as $item)
                                <li @click="$wire.toggleSelectItem({ id: {{ $item->id }}, item_name: '{{ addslashes($item->item_name) }}' })"
                                    wire:key="menu-item-lists-{{ $item->id }}"
                                    class="relative py-2 pl-3 text-gray-900 transition-colors duration-150 cursor-pointer select-none pr-9 hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800 dark:text-gray-300 dark:focus:border-gray-600 dark:focus:ring-gray-600"
                                    :class="{ 'bg-gray-100 dark:bg-gray-800': selectedMenuItems.includes({{ $item->id }}) }" role="option">
                                    <div class="flex items-center">
                                        <span class="block ml-3 truncate">{{ $item->item_name }}</span>
                                        <span x-show="selectedMenuItems.includes({{ $item->id }})" class="absolute inset-y-0 right-0 flex items-center pr-4 text-black dark:text-gray-300" x-cloak>
                                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="relative py-2 pl-3 text-gray-500 cursor-default select-none pr-9 dark:text-gray-400">
                                    {{ __('modules.modifier.noMenuItemsFound') }}
                                </li>
                            @endforelse
                        </ul>

                    </div>
                    <x-input-error for="selectedMenuItems" class="mt-2" />
                </div>
            </div>

            <div class="col-span-2 flex justify-baseline space-x-4 mt-6">
                <x-button type="submit" class="bg-green-500 hover:bg-green-700">{{ __('Save') }}</x-button>
                <x-button-cancel type="button" wire:click="$dispatch('hideAddModifierGroupModal')">{{ __('Cancel') }}</x-button-cancel>
            </div>
        </div>

    </form>
</div>
