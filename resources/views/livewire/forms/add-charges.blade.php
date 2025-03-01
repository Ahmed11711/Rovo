<div>
    <h2 class="text-lg font-bold mb-4 dark:text-white">
        @if($selectedChargeId)
            @lang('modules.settings.editCharge')
        @else
            @lang('modules.settings.addCharge')
        @endif
    </h2>

    <form wire:submit="submitForm" class="space-y-4">
        @csrf
        <div>
            <x-label for="charge_name" value="{{ __('modules.settings.chargeName') }}" />
            <x-input id="charge_name" class="block mt-1 w-full" type="text" wire:model="chargeName" placeholder="e.g. Service Charge" />
            <x-input-error for="chargeName" class="mt-2" />
        </div>

        <div class="flex space-x-4">
            <div class="w-2/3">
            <x-label for="charge_value" value="{{ __('modules.settings.rate') }}" />
            <x-input id="charge_value" type="number" step="0.01" class="block mt-1 w-full" wire:model="chargeValue" placeholder="e.g. 10" />
            <x-input-error for="chargeValue" class="mt-2" />
            </div>

            <div class="w-1/3">
            <x-label for="charge_type" value="{{ __('modules.settings.chargeType') }}" />
            <x-select id="charge_type" class="block mt-1 w-full" wire:model="chargeType">
                <option value="percent">@lang('modules.settings.percent')</option>
                <option value="fixed">@lang('modules.settings.fixed')</option>
            </x-select>
            <x-input-error for="chargeType" class="mt-2" />
            </div>

        </div>

        <div x-data="{ isOpen: false, selectedOrderTypes: @entangle('selectedOrderTypes') }" class="relative">
            <x-label for="order_types" value="{{ __('modules.settings.orderType') }}" />

            <!-- Dropdown Trigger -->
            <div class="block w-full p-2 border rounded bg-gray-100 cursor-pointer" @click="isOpen = !isOpen">
                <div class="flex flex-wrap gap-2">
                    @forelse ($selectedOrderTypes as $orderType)
                    <span class="px-2 py-0.5 text-xs font-semibold text-gray-800 bg-gray-100 border rounded-md flex items-center">
                        {{ $orderTypes[$orderType] ?? $orderType }}
                        <button type="button" wire:click.stop="toggleSelectOrderType('{{ $orderType }}')" class="ml-2 text-red-500">✖</button>
                    </span>
                    @empty
                    <span class="text-gray-400">@lang('Select Order Types')</span>
                    @endforelse
                </div>
            </div>

            <!-- Dropdown Options -->
            <ul x-show="isOpen" @click.away="isOpen = false" class="absolute z-10 w-full mt-1 bg-white border rounded-lg shadow-lg max-h-60 overflow-y-auto">
                @foreach ($orderTypes as $key => $label)
                <li wire:click="toggleSelectOrderType('{{ $key }}')" class="p-2 cursor-pointer hover:bg-gray-100 flex justify-between items-center">
                    {{ $label }}
                    <span class="text-green-500 font-bold" x-show="selectedOrderTypes.includes('{{ $key }}')">✔</span>
                </li>
                @endforeach
            </ul>
            <x-input-error for="selectedOrderTypes" class="mt-2" />
        </div>

        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@if($selectedChargeId) @lang('app.update') @else @lang('app.save') @endif</x-button>
            <x-button-cancel wire:click="$dispatch('hideShowChargesForm')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>

    </form>
</div>
