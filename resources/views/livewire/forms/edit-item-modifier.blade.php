<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="menuItem" :value="__('modules.modifier.menuItemName')" />
                <x-select id="menuItem" class="mt-1 block w-full" wire:model="menuItemId">
                    <option value="">@lang('modules.modifier.selectMenuItem')</option>
                    @foreach ($menuItems as $item)
                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="menuItemId" class="mt-2" />
            </div>

            <div>
                <x-label for="modifierGroupId" :value="__('modules.modifier.modifierGroup')" />
                <x-select id="modifierGroupId" class="mt-1 block w-full" wire:model="modifierGroupId">
                    <option value="">@lang('modules.modifier.selectModifierGroup')</option>
                    @foreach ($modifierGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
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
                <x-button-cancel wire:click="$dispatch('hideEditItemModifierModal')">@lang('app.cancel')</x-button-cancel>
            </div>
        </div>
    </form>
</div>
