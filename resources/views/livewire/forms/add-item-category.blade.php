<form wire:submit="submitForm">
    @csrf
    <div class="grid grid-cols-1">
        <x-label for="categoryName" :value="__('modules.menu.categoryName')" />

        <x-input id="categoryName" class="block mt-1 w-full" type="text"
            placeholder="{{ __('placeholders.categoryNamePlaceholder') }}" name="categoryName" autofocus
            wire:model='categoryName' />

        <x-input-error for="categoryName" class="mt-2" />
    </div>

    <div class="flex justify-end w-full pb-4 space-x-4 mt-6">
        <x-button class="ml-3">@lang('app.save')</x-button>
    </div>

</form>
