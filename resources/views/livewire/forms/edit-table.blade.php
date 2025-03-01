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
                <x-input id="seatingCapacity" class="block mt-1 w-full" type="number"  step='1' min='0' placeholder="{{ __('placeholders.tableSeatPlaceholder') }}" wire:model='seatingCapacity' />
                <x-input-error for="seatingCapacity" class="mt-2" />
            </div>

            <div>
                <x-label for="tableAvailability" value="{{ __('modules.table.tableAvailability') }}" />
                <x-select id="tableAvailability" class="mt-1 block w-full" wire:model="tableAvailability">
                    <option value="available">@lang('modules.table.available')</option>
                    <option value="running">@lang('modules.table.running')</option>
                    <option value="reserved">@lang('modules.table.reserved')</option>
                </x-select>
                <x-input-error for="tableAvailability" class="mt-2" />
            </div>

            <div>
                <x-label for="status" value="{{ __('app.status') }}" />
                <ul class="flex w-full gap-4 mt-1"  wire:key='status-tbl-{{ microtime() }}'>
                    <li  wire:key='status-tbls-{{ microtime() }}'>
                        <input type="radio" id="typeActives"  value="active" class="hidden peer"
                            wire:model='tableStatus'>
                        <label for="typeActives"
                            class="inline-flex items-center justify-between p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-green-600 peer-checked:border-green-600 peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            @lang('app.active')
                        </label>
                    </li>
                    <li  wire:key='status-tbls-{{ microtime() }}'>
                        <input type="radio" id="typeInactives" value="inactive" class="hidden peer"
                            wire:model='tableStatus' />
                        <label for="typeInactives"
                            class="inline-flex items-center justify-between p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-red-600 peer-checked:border-red-600 peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            @lang('app.inactive')
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-danger-button  wire:click="showDeleteTable"  wire:key='member-del-{{ $item->id . microtime() }}'>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                @lang('app.delete')
            </x-danger-button>
            <x-button-cancel  wire:click="$dispatch('hideEditTable')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>

    <x-confirmation-modal wire:model="confirmDeleteTableModal">
        <x-slot name="title">
            @lang('modules.table.deleteTable')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.table.deleteTableMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteTableModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($activeTable)
            <x-danger-button class="ml-3" wire:click='deleteTable' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
         </x-slot>
    </x-confirmation-modal>

</div>
