<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="area_id" :value="__('modules.table.chooseArea')" />
                <x-select id="area_id" class="mt-1 block w-full" wire:model="area">
                    <option value="">--</option>
                    @foreach ($areas as $item)
                    <option value="{{ $item->id }}">{{ $item->area_name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="area" class="mt-2" />
            </div>

            <div>
                <x-label for="tableCode" value="{{ __('modules.table.tableCode') }}" />
                <x-input id="tableCode" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.tableCodePlaceholder') }}" wire:model='tableCode' />
                <x-input-error for="tableCode" class="mt-2" />
            </div>

            <div>
                <x-label for="seatingCapacity" value="{{ __('modules.table.seatingCapacity') }}" />
                <x-input id="seatingCapacity" class="block mt-1 w-full" type="number" step='1' min='0' placeholder="{{ __('placeholders.tableSeatPlaceholder') }}" wire:model='seatingCapacity' />
                <x-input-error for="seatingCapacity" class="mt-2" />
            </div>

            <div>
                <x-label for="status" value="{{ __('app.status') }}" />
                <ul class="flex w-full gap-4 mt-1">
                    <li>
                        <input type="radio" id="typeActive"  value="active" class="hidden peer"
                            wire:model='tableStatus'>
                        <label for="typeActive"
                            class="inline-flex items-center justify-between p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-green-600 peer-checked:border-green-600 peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            @lang('app.active')
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="typeInactive" value="inactive" class="hidden peer"
                            wire:model='tableStatus' />
                        <label for="typeInactive"
                            class="inline-flex items-center justify-between p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-red-600 peer-checked:border-red-600 peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            @lang('app.inactive')
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideAddTable')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
