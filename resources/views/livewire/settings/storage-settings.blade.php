<div
    class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

    <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.storageSettings')</h3>

    <x-alert type="secondary">
        <ul>
            <li class="py-2"> &bull;
                <b>Local</b> @lang('modules.settings.localStorageNote')</li>
            <li> &bull; @lang('modules.settings.storageSuggestion')</li>
        </ul>
    </x-alert>


    <form wire:submit.prevent="submitForm">
        <div class="grid gap-6">

            <div>
                <x-label value="{{ __('modules.settings.selectStorage') }}" class="mb-4" />
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <!-- Local Storage -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="storage" value="local" wire:model.live="storage" class="peer sr-only">
                        <div class="p-4 border-2 rounded-lg hover:border-gray-300 peer-checked:border-skin-base transition-all duration-200 dark:border-gray-600 dark:hover:border-gray-400">
                            <div class="flex flex-col items-center gap-3">
                                <div class="flex justify-end w-full -mb-2">
                                    <span  class="text-xs">&nbsp;</a>
                                </div>
                                <svg class="w-12 h-12 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="font-medium text-sm text-gray-900 dark:text-gray-100">@lang('modules.settings.local')</span>
                            </div>
                        </div>
                    </label>

                    <!-- DigitalOcean -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="storage" value="digitalocean" wire:model.live="storage" class="peer sr-only">
                        <div class="p-4 border-2 rounded-lg hover:border-gray-300 peer-checked:border-skin-base transition-all duration-200 dark:border-gray-600 dark:hover:border-gray-400">
                            <div class="flex flex-col items-center gap-3">
                                <div class="flex justify-end w-full -mb-2">
                                    <a href="https://digitalocean.pxf.io/froiden" target="_blank" class="text-xs text-blue-500 hover:underline flex items-center gap-1">
                                        Docs
                                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                <polyline points="15 3 21 3 21 9"></polyline>
                                                <line x1="10" y1="14" x2="21" y2="3"></line>
                                            </svg>
                                        </a>
                                </div>
                                <svg class="w-12 h-12" viewBox="0 0 512 512" fill="#0080FF">
                                    <path d="M256 504v-96.1c101.8 0 180.8-100.9 141.7-208-14.3-39.6-41.9-67.3-81.5-81.6-107.1-39.1-208 39.9-208 141.7H8C8 93.7 164.9-32.8 335 20.3c74.2 23.1 133.6 82.4 156.7 156.7C544.8 347.1 418.3 504 256 504zm-85.5-188.4H256v85.5h-85.5v-85.5zm-84.4 0h48.2v85.5H86.1v-85.5zm85.5-83.3h47.1v47.1h-47.1v-47.1z"/>
                                </svg>
                                <span class="font-medium text-sm text-gray-900 dark:text-gray-100">@lang('modules.settings.digitalocean')</span>
                            </div>
                        </div>
                    </label>

                    <!-- AWS S3 -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="storage" value="aws_s3" wire:model.live="storage" class="peer sr-only">
                        <div class="p-4 border-2 rounded-lg hover:border-gray-300 peer-checked:border-skin-base transition-all duration-200 dark:border-gray-600 dark:hover:border-gray-400">
                            <div class="flex flex-col items-center gap-3">
                                <div class="flex justify-end w-full -mb-2">
                                    <a href="https://aws.amazon.com/s3" target="_blank" class="text-xs text-blue-500 hover:underline flex items-center gap-1">
                                        Docs
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                    </a>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" viewBox="0 0 428 512">
                                    <defs>
                                    <style>
                                        .cls-1 {
                                        fill: #e25444;
                                        }

                                        .cls-1, .cls-2, .cls-3 {
                                        fill-rule: evenodd;
                                        }

                                        .cls-2 {
                                        fill: #7b1d13;
                                        }

                                        .cls-3 {
                                        fill: #58150d;
                                        }
                                    </style>
                                    </defs>
                                    <path class="cls-1" d="M378,99L295,257l83,158,34-19V118Z"/>
                                    <path class="cls-2" d="M378,99L212,118,127.5,257,212,396l166,19V99Z"/>
                                    <path class="cls-3" d="M43,99L16,111V403l27,12L212,257Z"/>
                                    <path class="cls-1" d="M42.637,98.667l169.587,47.111V372.444L42.637,415.111V98.667Z"/>
                                    <path class="cls-3" d="M212.313,170.667l-72.008-11.556,72.008-81.778,71.83,81.778Z"/>
                                    <path class="cls-3" d="M284.143,159.111l-71.919,11.733-71.919-11.733V77.333"/>
                                    <path class="cls-3" d="M212.313,342.222l-72.008,13.334,72.008,70.222,71.83-70.222Z"/>
                                    <path class="cls-2" d="M212,16L140,54V159l72.224-20.333Z"/>
                                    <path class="cls-2" d="M212.224,196.444l-71.919,7.823V309.105l71.919,8.228V196.444Z"/>
                                    <path class="cls-2" d="M212.224,373.333L140.305,355.3V458.363L212.224,496V373.333Z"/>
                                    <path class="cls-1" d="M284.143,355.3l-71.919,18.038V496l71.919-37.637V355.3Z"/>
                                    <path class="cls-1" d="M212.224,196.444l71.919,7.823V309.105l-71.919,8.228V196.444Z"/>
                                    <path class="cls-1" d="M212,16l72,38V159l-72-20V16Z"/>
                                </svg>
                                <span class="font-medium text-sm text-gray-900 dark:text-gray-100">@lang('modules.settings.aws_s3')</span>
                            </div>
                        </div>
                    </label>

                    <!-- Wasabi -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="storage" value="wasabi" wire:model.live="storage" class="peer sr-only">
                        <div class="p-4 border-2 rounded-lg hover:border-gray-300 peer-checked:border-skin-base transition-all duration-200 dark:border-gray-600 dark:hover:border-gray-400">
                            <div class="flex flex-col items-center gap-3">
                                <div class="flex justify-end w-full -mb-2">
                                    <a href="https://wasabi.com" target="_blank" class="text-xs text-blue-500 hover:underline flex items-center gap-1">
                                        Docs
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                    </a>
                                </div>
                                <svg class="w-12 h-12" viewBox="0 0 32 32">
                                    <path fill="#00CE3E" d="M16 2L3 9v14l13 7 13-7V9L16 2zm-1 7h2v14h-2V9zm1 16a2 2 0 110-4 2 2 0 010 4z"/>
                                </svg>
                                <span class="font-medium text-sm text-gray-900 dark:text-gray-100">@lang('modules.settings.wasabi')</span>
                            </div>
                        </div>
                    </label>

                    <!-- MinIO -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="storage" value="minio" wire:model.live="storage" class="peer sr-only">
                        <div class="p-4 border-2 rounded-lg hover:border-gray-300 peer-checked:border-skin-base transition-all duration-200 dark:border-gray-600 dark:hover:border-gray-400">
                            <div class="flex flex-col items-center gap-3">
                                <div class="flex justify-end w-full -mb-2">
                                    <a href="https://min.io/docs/minio/linux/index.html" target="_blank" class="text-xs text-blue-500 hover:underline flex items-center gap-1">
                                        Docs
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                    </a>
                                </div>
                                <svg class="w-12 h-12" viewBox="0 0 32 32">
                                    <path fill="#C72C48" d="M16 4L4 10v12l12 6 12-6V10L16 4zm0 2.73L25.17 11 16 15.27 6.83 11 16 6.73zM6 12.67l9 4.2v8.46l-9-4.5v-8.16zm11 12.66v-8.46l9-4.2v8.16l-9 4.5z"/>
                                </svg>
                                <span class="font-medium text-sm text-gray-900 dark:text-gray-100">@lang('modules.settings.minio')</span>
                            </div>
                        </div>
                    </label>
                </div>
                <x-input-error for="storage" class="mt-2" />
            </div>

            <div class="grid lg:grid-cols-2 lg:gap-6 gap-4">
                @if ($storage == 'digitalocean')
                    <div>
                        <x-label for="digitaloceanKey" value="{{ __('modules.settings.digitaloceanAccessKey') }}" />
                        <x-input type="text" id="digitaloceanKey" class="block mt-1 w-full" wire:model='digitaloceanKey' />
                        <x-input-error for="digitaloceanKey" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="digitaloceanSecretKey" value="{{ __('modules.settings.digitaloceanSecretKey') }}" />
                        <x-input-password type="text" id="digitaloceanSecretKey" class="block mt-1 w-full" wire:model='digitaloceanSecretKey' />
                        <x-input-error for="digitaloceanSecretKey" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="digitaloceanBucket" value="{{ __('modules.settings.digitaloceanBucket') }}" />
                        <x-input type="text" id="digitaloceanBucket" class="block mt-1 w-full" wire:model='digitaloceanBucket' />
                        <x-input-error for="digitaloceanBucket" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="digitaloceanRegion" value="{{ __('modules.settings.digitaloceanRegion') }}" />
                        <x-select id="digitaloceanRegion" class="block mt-1 w-full" wire:model='digitaloceanRegion'>
                            @foreach (\App\Models\StorageSetting::DIGITALOCEAN_REGIONS as $key => $data)
                                <option value="{{$key}}">{{ $data }} - {{ $key }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="digitaloceanRegion" class="mt-2" />
                    </div>
                @endif

                @if ($storage == 'aws_s3')
                    <div>
                        <x-label for="awsAccessKey" value="{{ __('modules.settings.awsAccessKey') }}" />
                        <x-input type="text" id="awsAccessKey" class="block mt-1 w-full" wire:model='awsAccessKey' />
                        <x-input-error for="awsAccessKey" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="awsSecretKey" value="{{ __('modules.settings.awsSecretKey') }}" />
                        <x-input-password type="text" id="awsSecretKey" class="block mt-1 w-full" wire:model='awsSecretKey' />
                        <x-input-error for="awsSecretKey" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="awsBucket" value="{{ __('modules.settings.awsBucket') }}" />
                        <x-input type="text" id="awsBucket" class="block mt-1 w-full" wire:model='awsBucket' />
                        <x-input-error for="awsBucket" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="awsRegion" value="{{ __('modules.settings.awsRegion') }}" />
                        <x-select id="awsRegion" class="block mt-1 w-full" wire:model='awsRegion'>
                            @foreach (\App\Models\StorageSetting::AWS_REGIONS as $key => $data)
                                <option value="{{$key}}">{{ $data }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="awsRegion" class="mt-2" />
                    </div>
                @endif

                @if ($storage == 'wasabi')
                    <div>
                        <x-label for="wasabiAccessKey" value="{{ __('modules.settings.wasabiAccessKey') }}" />
                        <x-input type="text" id="wasabiAccessKey" class="block mt-1 w-full" wire:model='wasabiAccessKey' />
                        <x-input-error for="wasabiAccessKey" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="wasabiSecretKey" value="{{ __('modules.settings.wasabiSecretKey') }}" />
                        <x-input-password type="text" id="wasabiSecretKey" class="block mt-1 w-full" wire:model='wasabiSecretKey' />
                        <x-input-error for="wasabiSecretKey" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="wasabiBucket" value="{{ __('modules.settings.wasabiBucket') }}" />
                        <x-input type="text" id="wasabiBucket" class="block mt-1 w-full" wire:model='wasabiBucket' />
                        <x-input-error for="wasabiBucket" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="wasabiRegion" value="{{ __('modules.settings.wasabiRegion') }}" />
                        <x-select id="wasabiRegion" class="block mt-1 w-full" wire:model='wasabiRegion'>
                            @foreach (\App\Models\StorageSetting::WASABI_REGIONS as $key => $data)
                                <option value="{{$key}}">{{ $data }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="wasabiRegion" class="mt-2" />
                    </div>
                @endif

                @if ($storage == 'minio')
                    <div>
                        <x-label for="minioEndpoint" value="{{ __('modules.settings.minioEndpoint') }}" />
                        <x-input type="text" id="minioEndpoint" class="block mt-1 w-full" wire:model='minioEndpoint' placeholder="https://minio:9000" />
                        <x-input-error for="minioEndpoint" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="minioAccessKey" value="{{ __('modules.settings.minioAccessKey') }}" />
                        <x-input type="text" id="minioAccessKey" class="block mt-1 w-full" wire:model='minioAccessKey' />
                        <x-input-error for="minioAccessKey" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="minioSecretKey" value="{{ __('modules.settings.minioSecretKey') }}" />
                        <x-input-password type="text" id="minioSecretKey" class="block mt-1 w-full" wire:model='minioSecretKey' />
                        <x-input-error for="minioSecretKey" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="minioBucket" value="{{ __('modules.settings.minioBucket') }}" />
                        <x-input type="text" id="minioBucket" class="block mt-1 w-full" wire:model='minioBucket' />
                        <x-input-error for="minioBucket" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="minioRegion" value="{{ __('modules.settings.minioRegion') }}" />
                        <x-input type="text" id="minioRegion" class="block mt-1 w-full" wire:model='minioRegion' />
                        <x-input-error for="minioRegion" class="mt-2" />
                    </div>


                @endif
            </div>
            <div class="flex gap-4 ">
                <x-button>@lang('app.save')</x-button>

                @if ($storage != 'local')
                    <x-secondary-button wire:click="showTestStorage">@lang('modules.settings.testStorage')</x-secondary-button>
                @endif

                @if($localFilesCount > 0 && $storage != 'local')
                    <x-secondary-button wire:click="showMoveFilesToCloud">@lang('modules.settings.moveFilesToCloud')</x-secondary-button>
                @endif

            </div>
        </div>
    </form>


    <x-right-modal wire:model.live="showTestStorageModal">
        <x-slot name="title">
            {{ __("modules.settings.testStorage") }}
        </x-slot>

        <x-slot name="content">
            @livewire('forms.testStorage')
        </x-slot>
    </x-right-modal>


    @if($localFilesCount > 0 && $storage != 'local')
        <x-right-modal wire:model.live="showMoveFilesToCloudModal" maxWidth="3xl">
            <x-slot name="title">
                {{ __("modules.settings.moveFilesToCloud") }}
            </x-slot>

            <x-slot name="content">
                @livewire('forms.moveFilesToCloud')
            </x-slot>
        </x-right-modal>
    @endif

</div>
