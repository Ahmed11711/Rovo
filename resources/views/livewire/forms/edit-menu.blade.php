<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
               
            <div>
                <x-label for="menu_name" value="{{ __('modules.menu.menuName') }}" />
                <x-input id="menu_name" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.menuNamePlaceholder') }}" name="menu_name" wire:model='menuName' />
                <x-input-error for="menuName" class="mt-2" />
            </div>
        </div>
           
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideEditMenu')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
