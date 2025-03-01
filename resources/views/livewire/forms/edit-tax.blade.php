<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
               
            <div>
                <x-label for="taxName" value="{{ __('modules.settings.taxName') }}" />
                <x-input id="taxName" class="block mt-1 w-full" type="text" autofocus wire:model='taxName' />
                <x-input-error for="taxName" class="mt-2" />
            </div>

            <div>
                <x-label for="taxPercent" value="{{ __('modules.settings.taxPercent') }}" />
                <x-input id="taxPercent" class="block mt-1 w-full" type="text" autofocus wire:model='taxPercent' />
                <x-input-error for="taxPercent" class="mt-2" />
            </div>

        </div>
           
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideEditCurrency')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
