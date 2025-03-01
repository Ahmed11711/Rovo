<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
               
            <div>
                <x-label for="areaName" value="{{ __('modules.table.areaName') }}" />
                <x-input id="areaName" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.areaNamePlaceholder') }}" autofocus wire:model='areaName' />
                <x-input-error for="areaName" class="mt-2" />
            </div>
        </div>
           
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideEditArea')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
