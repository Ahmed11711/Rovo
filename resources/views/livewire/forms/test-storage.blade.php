<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">

            @if($fileUrl)

                <x-alert type="success">
                    <div class="flex justify-between w-full">
                        {{ __('messages.fileUploaded') }}
                        <a href="{{ $fileUrl }}" target="_blank" class="underline underline-offset-1">@lang('app.view')</a>
                    </div>
                </x-alert>

            </div>
            @endif

            <!-- Error Message -->
            @error('file_error')
            <x-alert type="danger">
                <div>
                    {!! $message !!}
             </div>
            </x-alert>
            @enderror

            <div>
                <x-label for="file" value="{{ __('modules.settings.testStorageFile') }}" />

                <input
                    class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 text-slate-500 mt-1"
                    type="file" wire:model="file">

                <x-input-error for="file" class="mt-2" />
            </div>

        </div>

        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideTestStorageModal')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
