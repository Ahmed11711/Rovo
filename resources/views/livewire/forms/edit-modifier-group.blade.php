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

            <div class="col-span-2 flex justify-baseline space-x-4 mt-6">
                <x-button type="submit" class="bg-green-500 hover:bg-green-700">@lang('app.save')</x-button>
                <x-button-cancel type="button" wire:click="$dispatch('hideEditModifierGroupModal')">@lang('app.cancel')</x-button-cancel>
            </div>
        </div>
    </form>
</div>
