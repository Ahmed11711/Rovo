<div
    class="mx-4 p-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
            @lang('modules.settings.customerSiteSettings')
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            @lang('modules.settings.customerSiteSettingsDescription')
        </p>
    </div>

    <form wire:submit="submitForm" class="space-y-6">
        <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
            <!-- Order Settings Section -->
            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    @lang('modules.settings.orderSettings')
                </h4>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <x-label for="allowCustomerOrders" :value="__('modules.settings.allowCustomerOrders')" class="!mb-1" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.allowCustomerOrdersDescription')</p>
                        </div>
                        <x-checkbox name="allowCustomerOrders" id="allowCustomerOrders"
                            wire:model.live='allowCustomerOrders' class="ml-4" />
                    </div>

                    <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <x-label for="customerLoginRequired" :value="__('modules.settings.customerLoginRequired')" class="!mb-1" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.customerLoginRequiredDescription')</p>
                        </div>
                        <x-checkbox name="customerLoginRequired" id="customerLoginRequired"
                            wire:model='customerLoginRequired' class="ml-4" />
                    </div>

                    <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <x-label for="allowDineIn" :value="__('modules.settings.allowDineIn')" class="!mb-1" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.allowDineInDescription')</p>
                        </div>
                        <x-checkbox name="allowDineIn" id="allowDineIn" wire:model='allowDineIn' class="ml-4" />
                    </div>

                    <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <x-label for="allowCustomerDeliveryOrders" :value="__('modules.settings.allowCustomerDeliveryOrders')" class="!mb-1" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.allowCustomerDeliveryOrdersDescription')</p>
                        </div>
                        <x-checkbox name="allowCustomerDeliveryOrders" id="allowCustomerDeliveryOrders"
                            wire:model='allowCustomerDeliveryOrders' class="ml-4" />
                    </div>

                    <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <x-label for="allowCustomerPickupOrders" :value="__('modules.settings.allowCustomerPickupOrders')" class="!mb-1" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.allowCustomerPickupOrdersDescription')</p>
                        </div>
                        <x-checkbox name="allowCustomerPickupOrders" id="allowCustomerPickupOrders"
                            wire:model='allowCustomerPickupOrders' class="ml-4" />
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    @lang('modules.settings.callWaiterSettings')
                </h4>

                <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                    <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <x-label for="isWaiterRequestEnabled" :value="__('modules.settings.isWaiterRequestEnabled')" class="!mb-1" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.isWaiterRequestEnabledDescription')</p>
                        </div>
                        <x-checkbox name="isWaiterRequestEnabled" id="isWaiterRequestEnabled"
                            wire:model.live='isWaiterRequestEnabled' class="ml-4" />
                    </div>

                    @if ($isWaiterRequestEnabled)
                        <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <div class="flex-1">
                                <x-label for="onDesktop" :value="__('modules.settings.onDesktop')" class="!mb-1" />
                                <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.onDesktopDescription')</p>
                            </div>
                            <x-checkbox name="isWaiterRequestEnabledOnDesktop" id="isWaiterRequestEnabledOnDesktop" 
                                wire:model.live='isWaiterRequestEnabledOnDesktop' class="ml-4" />
                        </div>

                        <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <div class="flex-1">
                                <x-label for="onMobile" :value="__('modules.settings.onMobile')" class="!mb-1" />
                                <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.onMobileDescription')</p>
                            </div>
                            <x-checkbox name="isWaiterRequestEnabledOnMobile" id="isWaiterRequestEnabledOnMobile" 
                                wire:model='isWaiterRequestEnabledOnMobile' class="ml-4" />
                        </div>

                        <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <div class="flex-1">
                                <x-label for="openViaQrCode" :value="__('modules.settings.openViaQrCode')" class="!mb-1" />
                                <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.openViaQrCodeDescription')</p>
                            </div>
                            <x-checkbox name="isWaiterRequestEnabledOpenByQr" id="isWaiterRequestEnabledOpenByQr" 
                                wire:model='isWaiterRequestEnabledOpenByQr' class="ml-4" />
                        </div>
                    @endif

                </div>
            </div>
            <!-- Dine-in Settings Section -->
            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    @lang('modules.settings.dineInSettings')
                </h4>
                <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                  
                    <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <x-label for="tableRequired" :value="__('modules.settings.tableRequiredDineIn')" class="!mb-1" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">@lang('modules.settings.tableRequiredDineInDescription')</p>
                        </div>
                        <x-checkbox name="tableRequired" id="tableRequired" wire:model='tableRequired' class="ml-4" />
                    </div>

                    <div class="sm:col-span-2 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <x-label for="defaultReservationStatus" :value="__('modules.settings.defaultReservationStatus')" class="!mb-1" />
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">@lang('modules.settings.defaultReservationStatusDescription')</p>
                        <select id="defaultReservationStatus" wire:model="defaultReservationStatus"
                            class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                            <option value="Confirmed">@lang('modules.settings.reservationStatusConfirmed')</option>
                            <option value="Pending">@lang('modules.settings.reservationStatusPending')</option>
                            <option value="Checked_In">@lang('modules.settings.reservationStatusCheckedIn')</option>
                            <option value="Cancelled">@lang('modules.settings.reservationStatusCancelled')</option>
                            <option value="No_Show">@lang('modules.settings.reservationStatusNoShow')</option>
                        </select>
                    </div>

                </div>


            </div>

            <!-- Social Media Links Section -->
            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    @lang('modules.settings.socialMediaLinks')
                </h4>
                <div class="grid gap-4">
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <x-label for="facebook" :value="__('modules.settings.facebook_link')" class="!mb-1" />
                        <x-input id="facebook" class="block w-full mt-1" type="url"
                            placeholder="{{ __('placeholders.facebookPlaceHolder') }}" wire:model='facebook' />
                        <x-input-error for="facebook" class="mt-2" />
                    </div>

                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <x-label for="instagram" :value="__('modules.settings.instagram_link')" class="!mb-1" />
                        <x-input id="instagram" class="block w-full mt-1" type="url"
                            placeholder="{{ __('placeholders.instagramPlaceHolder') }}" wire:model='instagram' />
                        <x-input-error for="instagram" class="mt-2" />
                    </div>

                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <x-label for="twitter" :value="__('modules.settings.twitter_link')" class="!mb-1" />
                        <x-input id="twitter" class="block w-full mt-1" type="url"
                            placeholder="{{ __('placeholders.twitterPlaceHolder') }}" wire:model='twitter' />
                        <x-input-error for="twitter" class="mt-2" />
                    </div>

                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <x-label for="yelp" :value="__('modules.settings.yelp_link')" class="!mb-1" />
                        <x-input id="yelp" class="block w-full mt-1" type="url"
                            placeholder="{{ __('placeholders.yelpPlaceHolder') }}" wire:model='yelp' />
                        <x-input-error for="yelp" class="mt-2" />
                    </div>

                </div>
            </div>

            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
             @lang('modules.settings.seo')
                </h4>
                <div class="grid gap-4">

                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <x-label for="metaKeyword" value="{{ __('modules.settings.metaKeyword') }}" />
                        <x-input id="metaKeyword" class="block mt-1 w-full" type="text"
                            placeholder="{{ __('placeholders.metaKeywordPlaceHolder') }}" autofocus
                            wire:model='metaKeyword' />
                        <x-input-error for="metaKeyword" class="mt-2" />
                    </div>

                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <x-label for="metaDescription" value="{{ __('modules.settings.metaDescription') }}" />
                        <x-textarea id="metaDescription" class="block mt-1 w-full"
                            placeholder="{{ __('placeholders.metaDescriptionPlaceHolder') }}" autofocus
                            wire:model='metaDescription'></x-textarea>
                        <x-input-error for="metaDescription" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <x-button>
                @lang('app.save')
            </x-button>
        </div>
    </form>
</div>
