<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="grid grid-cols-2 gap-4">
               
            <div>
                <x-label for="restaurantCurrency" value="{{ __('modules.settings.restaurantCurrency') }}" />
                <x-input id="restaurantCurrency" class="block mt-1 w-full" type="text" autofocus wire:model='restaurantCurrency' />
                <x-input-error for="restaurantCurrency" class="mt-2" />
            </div>

            <div>
                <x-label for="currencySymbol" value="{{ __('modules.settings.currencySymbol') }}" />
                <x-input id="currencySymbol" class="block mt-1 w-full" type="text" autofocus wire:model='currencySymbol' />
                <x-input-error for="currencySymbol" class="mt-2" />
            </div>

            <div>
                <x-label for="currencyCode" value="{{ __('modules.settings.currencyCode') }}" />
                <x-input id="currencyCode" class="block mt-1 w-full" type="text" autofocus wire:model='currencyCode' />
                <x-input-error for="currencyCode" class="mt-2" />
            </div>

        </div>


        <h3 class="text-lg mt-4">@lang('modules.settings.currencyFormat')</h3>

        <div class="grid grid-cols-2 gap-4 mt-4">

               
            <div>
                <x-label for="currencyPosition" value="{{ __('modules.settings.currencyPosition') }}" />
                <x-select id="currencyPosition" class="block mt-1 w-full" autofocus wire:model.live='currencyPosition'>
                    <option value="left">{{ __('modules.settings.left') }}</option>
                    <option value="right">{{ __('modules.settings.right') }}</option>
                    <option value="left_with_space">{{ __('modules.settings.leftWithSpace') }}</option>
                    <option value="right_with_space">{{ __('modules.settings.rightWithSpace') }}</option>
                </x-select>
                <x-input-error for="currencyPosition" class="mt-2" />
            </div>

            <div>
                <x-label for="thousandSeparator" value="{{ __('modules.settings.thousandSeparator') }}" />
                <x-input id="thousandSeparator" class="block mt-1 w-full" type="text" autofocus wire:model.live='thousandSeparator' />
                <x-input-error for="thousandSeparator" class="mt-2" />
            </div>

            <div>
                <x-label for="decimalSeparator" value="{{ __('modules.settings.decimalSeparator') }}" />
                <x-input id="decimalSeparator" class="block mt-1 w-full" type="text" autofocus wire:model.live='decimalSeparator' />
                <x-input-error for="decimalSeparator" class="mt-2" />
            </div>

            <div>
                <x-label for="numberOfdecimals" value="{{ __('modules.settings.numberOfdecimals') }}" />
                <x-input id="numberOfdecimals" class="block mt-1 w-full" type="number" min="0" autofocus wire:model.live='numberOfDecimals' />
                <x-input-error for="numberOfDecimals" class="mt-2" />
            </div>

        </div>

        <div class="mt-4 bg-gray-100 p-4 rounded-md font-medium">
            @lang('app.example') : {{ $sampleFormat }}
        </div>
           
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideAddCurrency')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
