<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
               
            <div>
                <x-label for="memberName" value="{{ __('modules.staff.name') }}" />
                <x-input id="memberName" class="block mt-1 w-full" type="text" autofocus wire:model='memberName' />
                <x-input-error for="memberName" class="mt-2" />
            </div>

            <div>
                <x-label for="memberPhone" value="{{ __('modules.restaurant.phone') }}" />
                <x-input id="memberPhone" class="block mt-1 w-full" type="tel" autofocus wire:model='memberPhone' />
                <x-input-error for="memberPhone" class="mt-2" />
            </div>

            <div>
                <x-label for="status" value="{{ __('app.status') }}" />

                <x-select  class="mt-1 block w-full" wire:model='status'>
                    <option value="available">@lang('modules.staff.available')</option>
                    <option value="inactive">@lang('modules.staff.inactive')</option>
                </x-select>

                <x-input-error for="status" class="mt-2" />
            </div>

        </div>
           
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideAddStaff')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
