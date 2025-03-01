<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
               
            <div>
                <x-label for="languageCode" value="{{ __('modules.language.languageCode') }}" />
                <x-input id="languageCode" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.languageCodePlaceholder') }}" autofocus wire:model='languageCode' />
                <x-input-error for="languageCode" class="mt-2" />
            </div>

            <div>
                <x-label for="languageName" value="{{ __('modules.language.languageName') }}" />
                <x-input id="languageName" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.languageNamePlaceholder') }}" wire:model='languageName' />
                <x-input-error for="languageName" class="mt-2" />
            </div>

            <div>
                <div class="flex items-center gap-2">
                    <x-label for="flagCode" value="{{ __('modules.language.flagCode') }}" />
                    <a href="https://flagicons.lipis.dev/" class="text-skin-base underline underline-offset-1 font-medium" target="_blank">
                        @lang('modules.language.flagCodeHelp')
                    </a>
                </div>

                <x-input id="flagCode" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.flagCodePlaceholder') }}" wire:model='flagCode' />
                <x-input-error for="flagCode" class="mt-2" />
            </div>

            <div>
                <x-label for="isRtl">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="isRtl" id="isRtl" wire:model.live='isRtl'/>

                        <div class="ms-2">
                            @lang('modules.language.rtl')
                        </div>
                    </div>
                </x-label>
            </div>
        </div>
           
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideAddLanguage')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>

