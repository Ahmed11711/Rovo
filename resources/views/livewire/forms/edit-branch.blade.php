<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="branchName" value="{{ __('modules.settings.branchName') }}" />
                <x-input id="branchName" class="block mt-1 w-full" type="text"  wire:model='branchName' />
                <x-input-error for="branchName" class="mt-2" />
            </div>

            <div>
                <x-label for="branchAddress" value="{{ __('modules.settings.branchAddress') }}" />
                <x-textarea id="branchAddress" class="block mt-1 w-full" rows="3" wire:model='branchAddress' />
                <x-input-error for="branchAddress" class="mt-2" />
            </div>

        </div>
           
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideEditBranch')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>

</div>
