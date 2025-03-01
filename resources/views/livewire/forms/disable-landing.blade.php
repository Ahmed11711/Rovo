<div
    class="mx-4 p-4 m-4 bg-white border border-gray-200 rounded-lg shadow-sm col-span-3 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

        <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.disableLandingSite')</h3>
        <x-help-text class="mb-6">@lang('modules.settings.disableLandingSiteHelp')</x-help-text>

        <form wire:submit="submitForm">
            <div class="grid grid-cols-2 gap-6">
            <div class="border p-4 rounded-lg dark:border-gray-500 space-y-4">
                    <div>
                        <x-label for="disableLandingSite">
                            <div class="flex items-center cursor-pointer">
                                <x-checkbox name="disableLandingSite" id="disableLandingSite"
                                    wire:model.live='disableLandingSite' />

                                <div class="ms-2">
                                    @lang('modules.settings.disableLandingSite')
                                </div>
                            </div>
                        </x-label>
                    </div>
                    @if (!$disableLandingSite)
                        <div>
                            <x-label for="landingSiteType" :value="__('modules.settings.landingSiteType')" />
                            <x-select id="landingSiteType" class="mt-1 block w-full" wire:model.live="landingSiteType">
                                <option value="theme">@lang('modules.settings.theme')</option>
                                <option value="custom">@lang('modules.settings.custom')</option>
                            </x-select>
                            <x-input-error for="landingSiteType" class="mt-2" />
                        </div>

                        @if ($landingSiteType == 'custom')
                            <div>
                                <x-label for="landingSiteUrl" value="Landing Site URL" />
                                <x-input id="landingSiteUrl" class="block mt-1 w-full" type="text"
                                    wire:model='landingSiteUrl' />
                                <x-input-error for="landingSiteUrl" class="mt-2" />
                            </div>
                        @endif

                        @if ($landingSiteType == 'theme')
                            <div>
                                <x-label for="facebook" value="{{ __('modules.settings.facebook_link') }}" />
                                <x-input id="facebook" class="block mt-1 w-full" type="url"
                                    placeholder="{{ __('placeholders.facebookPlaceHolder') }}" autofocus
                                    wire:model='facebook' />
                                <x-input-error for="facebook" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="instagram" value="{{ __('modules.settings.instagram_link') }}" />
                                <x-input id="instagram" class="block mt-1 w-full" type="url"
                                    placeholder="{{ __('placeholders.instagramPlaceHolder') }}" autofocus
                                    wire:model='instagram' />
                                <x-input-error for="instagram" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="twitter" value="{{ __('modules.settings.twitter_link') }}" />
                                <x-input id="twitter" class="block mt-1 w-full" type="url"
                                    placeholder="{{ __('placeholders.twitterPlaceHolder') }}" autofocus
                                    wire:model='twitter' />
                                <x-input-error for="twitter" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="yelp" value="{{ __('modules.settings.yelp_link') }}" />
                                <x-input id="yelp" class="block mt-1 w-full" type="url"
                                    placeholder="{{ __('placeholders.yelpPlaceHolder') }}" autofocus
                                    wire:model='yelp' />
                                <x-input-error for="yelp" class="mt-2" />
                            </div>

                        @endif
                    @endif
                </div>

                <div class="border p-4 rounded-lg dark:border-gray-500 space-y-4">
                    <div>
                        <x-label for="metaKeyword" value="{{ __('modules.settings.metaKeyword') }}" />
                        <x-input id="metaKeyword" class="block mt-1 w-full" type="text"
                            placeholder="{{ __('placeholders.metaKeywordPlaceHolder') }}" autofocus
                            wire:model='metaKeyword' />
                        <x-input-error for="metaKeyword" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="metaDescription" value="{{ __('modules.settings.metaDescription') }}" />
                        <x-textarea id="metaDescription" class="block mt-1 w-full"
                            placeholder="{{ __('placeholders.metaDescriptionPlaceHolder') }}" autofocus
                            wire:model='metaDescription'></x-textarea>
                        <x-input-error for="metaDescription" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-button>@lang('app.save')</x-button>
                </div>
            </div>


        </form>
</div>
