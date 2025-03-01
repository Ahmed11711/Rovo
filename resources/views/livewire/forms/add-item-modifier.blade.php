<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="menuItem" :value="__('modules.modifier.menuItemName')" />
                <x-select id="menuItem" class="mt-1 block w-full" wire:model="menuItemId">
                    <option value="">{{ __('modules.modifier.selectMenuItem') }}</option>
                    @foreach ($menuItems as $item)
                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="menuItemId" class="mt-2" />
            </div>

            <div>
                <x-label for="modifierGroupId" :value="__('modules.modifier.modifierGroup')" />
                <x-select id="modifierGroupId" class="mt-1 block w-full" wire:model="modifierGroupId">
                    <option value="">{{ __('modules.modifier.selectModifierGroup') }}</option>
                    @foreach ($modifierGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach

                    <!-- future use if needed -->
                    {{-- <x-slot name="append">
                        <button class="font-semibold border-l-0 text-sm toggle-password"
                            wire:click="$toggle('showAddModifierGroupModal')" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-gear-fill" viewBox="0 0 16 16">
                                <path
                                    d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                            </svg>
                        </button>
                    </x-slot> --}}
                </x-select>

                <x-input-error for="modifierGroupId" class="mt-2" />
            </div>


            <div class="mt-4">
                <x-label for="allowMultipleSelection">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox id="allowMultipleSelection" wire:model="allowMultipleSelection" />
                        <div class="flex flex-col items-start ms-3">
                            @lang('modules.modifier.allowMultipleSelection')
                            <span class="text-sm text-gray-600 dark:text-gray-400 select-none">{{ __('modules.modifier.allowMultipleSelectionDescription') }}</span>
                        </div>
                    </div>
                </x-label>
            </div>

            <div class="mt-4">
                <x-label for="isRequired">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="isRequired" id="isRequired" wire:model="isRequired" />
                        <div class="select-none ms-2">
                            @lang('modules.modifier.isRequired')
                        </div>
                    </div>
                </x-label>
            </div>

            <div class="flex w-full pb-4 space-x-4 mt-6">
                <x-button>@lang('app.save')</x-button>
                <x-button-cancel wire:click="$dispatch('hideAddItemModifierModal')">@lang('app.cancel')</x-button-cancel>
            </div>
        </div>
    </form>

    {{-- <x-right-modal wire:model.live="showAddModifierGroupModal">
        <x-slot name="title">
            {{ __('modules.modifier.addModifierGroup') }}
        </x-slot>

        <x-slot name="content">
            @if ($showAddModifierGroupModal)
            @livewire('forms.AddModifierGroup')
            @endif
        </x-slot>
    </x-right-modal> --}}
</div>
