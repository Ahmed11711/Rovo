<div class="offline_payment">
    <form wire:submit="offlinePaymentSubmit">
        @csrf

        <div>
            <x-label for="offlineUploadFile" value="{{ __('modules.billing.offlineUploadFile') }}" />
            <x-input type="file" id="offlineUploadFile" class="mt-1 block w-full" wire:model="offlineUploadFile" />
            <x-input-error for="offlineUploadFile" class="mt-2" />
        </div>

        <div>
            <div class="my-4">
                <x-label for="description" value="{{ __('modules.billing.description') }}" />
                <x-textarea id="description" class="block mt-1 w-full" wire:model="offlineDescription" rows="4" data-gramm="false" />
                <x-input-error for="offlineDescription" class="mt-2" />
            </div>
        </div>
    </form>
</div>
