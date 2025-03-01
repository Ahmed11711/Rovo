<div
    class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">



    <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.themeSettings')</h3>

    <form wire:submit="submitForm" x-data="{ photoName: null, photoPreview: null }">
        <div class="space-y-6">
            {{-- Logo Upload Section --}}
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-medium text-gray-900 dark:text-white">{{ __('app.logo') }}</h4>

                    </div>
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>

                <div class="flex items-center space-x-6">
                    {{-- Logo Preview --}}
                    <div class="flex-shrink-0">
                        <div class="relative h-24 w-24">
                            {{-- Current Logo --}}
                            <div x-show="!photoPreview"
                                class="h-24 w-24 rounded-lg bg-gray-50 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                <img src="{{ $settings->logo_url }}" alt="{{ $settings->name }}"
                                    class="h-24 w-24 object-contain">
                            </div>

                            {{-- New Logo Preview --}}
                            <div x-show="photoPreview" style="display: none;">
                                <span class="block h-24 w-24 rounded-lg bg-cover bg-center bg-no-repeat"
                                    x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                </span>
                            </div>

                            {{-- Loading State --}}
                            <div wire:loading wire:target="photo"
                                class="absolute inset-0 bg-gray-900/60 rounded-lg flex items-center justify-center">
                                <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Upload Controls --}}
                    <div class="flex-grow space-y-3">
                        <input type="file" id="photo" class="hidden"
                            accept="image/png, image/gif, image/jpeg, image/webp, image/svg+xml" wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />
                        {{-- <x-label for="photo" value="{{ __('app.logo') }}" /> --}}


                        <div class="flex flex-wrap gap-3">
                            <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()"
                                class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                {{ __('modules.settings.uploadLogo') }}
                            </x-secondary-button>

                            @if (global_setting()->logo)
                                <x-secondary-button type="button" wire:click="deleteLogo" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    {{ __('modules.settings.removeLogo') }}
                                </x-secondary-button>
                            @endif
                        </div>

                        <x-input-error for="logo" class="mt-2" />
                    </div>
                </div>
            </div>

            {{-- Show Logo Text Toggle --}}
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <x-checkbox name="showLogoText" id="showLogoText" wire:model="showLogoText" />

                        <div>
                            <label for="showLogoText" class="font-medium text-gray-900 dark:text-white">
                                @lang('modules.settings.showLogoText')
                            </label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @lang('modules.settings.showLogoTextDescription')
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Favicons Section --}}

           <div class="p-5 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between mb-3">
        <div>
            <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                {{ __('modules.settings.favicons') }}
            </h4>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                {{ __('modules.settings.faviconsDescription') }}
                <a href="https://favicon.io/favicon-converter/" target="_blank" class="text-xs underline">
                    {{ __('modules.settings.generateFavicon') }} →
                </a>
            </p>
        </div>
    </div>

    {{-- Favicons Inputs --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @foreach (['upload_fav_icon_android_chrome_192', 'upload_fav_icon_android_chrome_512', 'upload_fav_icon_apple_touch_icon', 'upload_favicon_16', 'upload_favicon_32', 'favicon'] as $index => $name)
            <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-2">
                <div class="flex items-center space-x-2">
                    <div class="flex-shrink-0">
                        <div id="filePreview{{ $name }}"
                            class="h-8 w-8 rounded bg-gray-50 dark:bg-gray-700 flex items-center justify-center overflow-hidden"
                            style="background-image: url('{{ ${$name} ? ${$name}->temporaryUrl() : asset('user-uploads/favicons/super-admin/' . $settings->$name) }}'); background-size: contain; background-repeat: no-repeat;">
                        </div>
                    </div>
                    <div class="flex-grow space-y-1">
                        <input type="file" id="{{ $name }}" class="hidden"
                            accept="image/png, image/gif, image/jpeg, image/webp, image/svg+xml, image/x-icon"
                            wire:model="{{ $name }}" x-ref="{{ $name }}"
                            x-on:change="
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    document.getElementById('filePreview{{ $name }}').style.backgroundImage = 'url(' + e.target.result + ')';
                                };
                                reader.readAsDataURL($refs.{{ $name }}.files[0]);
                            " />

                        <div class="flex flex-wrap gap-1">
                            <x-secondary-button type="button"
                                x-on:click.prevent="$refs.{{ $name }}.click()"
                                class="flex items-center text-xs px-2 py-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                {{ __('modules.settings.' . $name) }}
                            </x-secondary-button>
                        </div>

                        <x-input-error for="file{{ $index }}" class="mt-1 text-xs" />
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Web Manifest --}}
        <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-2">
            <div class="flex items-center space-x-2">

                  <div class="flex-shrink-0">
                        <div id="filePreview{{ $name }}"
                            class="h-8 w-8 rounded bg-gray-50 dark:bg-gray-700 flex items-center justify-center overflow-hidden"
                            style="background-image: url('{{ $webmanifest ? asset('img/jsonicon.png') : '' }}'); background-size: contain; background-repeat: no-repeat;">
                        </div>
                    </div>
                <div class="flex-grow space-y-1">
                    <input type="file" id="webmanifest" class="hidden"
                        accept="application/manifest+json" wire:model="webmanifest"
                        x-ref="webmanifest"
                        x-on:change="
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                document.getElementById('filePreviewWebManifest').style.backgroundImage = 'url(' + e.target.result + ')';
                            };
                            reader.readAsDataURL($refs.webmanifest.files[0]);
                        " />

                    <div class="flex flex-wrap gap-1">
                        <x-secondary-button type="button"
                            x-on:click.prevent="$refs.webmanifest.click()"
                            class="flex items-center text-xs px-2 py-1">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            {{ __('modules.settings.siteWebManifest') }}
                        </x-secondary-button>
                    </div>
                    <x-input-error for="webmanifest" class="mt-1 text-xs" />
                </div>
            </div>
        </div>
    </div>
</div>


            {{-- Theme Color Picker --}}
            <div
                class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-medium text-gray-900 dark:text-white">
                            {{ __('modules.settings.themeColor') }}</h4>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('modules.settings.themeColorDescription') }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $themeColor }}</span>
                        <input type="color"
                            class="p-1 h-8 w-12 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700"
                            id="themeColor" title="Choose your color" wire:model='themeColor'>
                    </div>
                </div>
                <div class="mt-4 space-y-6">
                    {{-- Professional Colors --}}
                    <div class="space-y-2">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">@lang('app.professional')</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['#2563EB', '#059669', '#7C3AED', '#0891B2', '#EA580C', '#4F46E5', '#0D9488', '#9333EA'] as $color)
                                <button type="button" wire:click="$set('themeColor', '{{ $color }}')"
                                    class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 hover:scale-110 transition-transform"
                                    style="background-color: {{ $color }}" title="{{ $color }}">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-200 dark:border-gray-700"></div>

                    {{-- Pastel Colors --}}
                    <div class="space-y-2">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">@lang('app.pastel')</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['#93C5FD', '#86EFAC', '#FDE68A', '#FDBA74', '#DDD6FE', '#99F6E4', '#FCA5A5', '#A5B4FC'] as $color)
                                <button type="button" wire:click="$set('themeColor', '{{ $color }}')"
                                    class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 hover:scale-110 transition-transform"
                                    style="background-color: {{ $color }}" title="{{ $color }}">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-200 dark:border-gray-700"></div>

                    {{-- Warm Colors --}}
                    <div class="space-y-2">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">@lang('app.warm')</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['#F97316', '#DC2626', '#D946EF', '#EC4899', '#F43F5E', '#FB923C', '#E11D48', '#F59E0B'] as $color)
                                <button type="button" wire:click="$set('themeColor', '{{ $color }}')"
                                    class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 hover:scale-110 transition-transform"
                                    style="background-color: {{ $color }}" title="{{ $color }}">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <x-input-error for="themeColor" class="mt-2" />
            </div>
            {{-- Save Button --}}
            <div class="flex items-center justify-end space-x-3">
                <x-button :disabled="$errors->any()" wire:loading.attr="disabled">
                    @lang('app.save')
                </x-button>
            </div>
        </div>
    </form>

</div>
