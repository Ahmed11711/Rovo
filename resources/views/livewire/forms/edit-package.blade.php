<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Breadcrumb -->
    <nav class="px-4 py-3 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <ol class="flex items-center space-x-2 text-sm font-medium">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    @lang('menu.dashboard')
                </a>
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('superadmin.packages.index') }}" class="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">@lang('menu.packages')</a>
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-400 dark:text-gray-500">@lang('modules.package.editPackage')</span>
            </li>
        </ol>
    </nav>

    @if($showPackageDetailsForm)
        <div class="mx-auto sm:px-6 ">
            <form wire:submit="submitForm" class="space-y-8">
                @csrf
                <!-- Header -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        @lang('modules.package.editPackage')
                    </h1>

                    <!-- Plan Type Selection -->
                    @if($packageType->isEditable())
                        <div class="mt-6">
                            <x-label value="{{ __('Select Plan Type') }}" class="mb-4 text-sm font-medium text-gray-700 dark:text-gray-300"/>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <label class="flex p-4 bg-white border-2 rounded-lg cursor-pointer transition-all duration-200 ease-in-out hover:shadow-md dark:bg-gray-800 dark:border-gray-700 {{ !$isFree ? 'border-skin-base shadow-lg bg-skin-base dark:bg-skin-base/10' : 'border-gray-200' }}">
                                        <input type="radio" wire:model.live='isFree' value="0" name="plan_type" class="absolute opacity-0">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex items-center">
                                                <div class="relative w-5 h-5">
                                                    <div class="absolute inset-0 w-5 h-5 border-2 border-gray-300 rounded-full {{ !$isFree ? 'border-skin-base' : '' }}"></div>
                                                    @if(!$isFree)
                                                        <div class="absolute inset-0 flex items-center justify-center">
                                                            <div class="w-3 h-3 bg-skin-base rounded-full"></div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-base font-semibold {{ !$isFree ? 'text-skin-base dark:text-blue-300' : 'text-gray-900 dark:text-gray-100' }}">@lang('modules.package.paidPlan')</p>
                                                    <p class="text-sm {{ !$isFree ? 'text-skin-base dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">Full access to all features</p>
                                                </div>
                                            </div>
                                            @if(!$isFree)
                                                <div class="shrink-0 text-skin-base">
                                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path d="M20 6L9 17L4 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </label>
                                </div>

                                <div class="relative">
                                    <label class="flex p-4 bg-white border-2 rounded-lg cursor-pointer transition-all duration-200 ease-in-out hover:shadow-md dark:bg-gray-800 dark:border-gray-700 {{ $isFree ? 'border-skin-base shadow-lg bg-skin-base dark:bg-skin-base/10' : 'border-gray-200' }}">
                                        <input type="radio" wire:model.live='isFree' value="1" name="plan_type" class="absolute opacity-0">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex items-center">
                                                <div class="relative w-5 h-5">
                                                    <div class="absolute inset-0 w-5 h-5 border-2 border-gray-300 rounded-full {{ $isFree ? 'border-skin-base' : '' }}"></div>
                                                    @if($isFree)
                                                        <div class="absolute inset-0 flex items-center justify-center">
                                                            <div class="w-3 h-3 bg-skin-base rounded-full"></div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-base font-semibold {{ $isFree ? 'text-skin-base dark:text-blue-300' : 'text-gray-900 dark:text-gray-100' }}">@lang('modules.package.freePlan')</p>
                                                    <p class="text-sm {{ $isFree ? 'text-skin-base dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">Limited access to basic features</p>
                                                </div>
                                            </div>
                                            @if($isFree)
                                                <div class="shrink-0 text-skin-base">
                                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path d="M20 6L9 17L4 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <x-label for="packageName" value="{{ __('modules.package.packageName') }}" />
                        <x-input id="packageName" class="block w-full mt-1" type="text" wire:model='packageName' />
                        <x-input-error for="packageName" class="mt-2" />
                    </div>

                    @if(!$isFree)
                        <div class="mt-4">
                            <x-label for="status" value="{{ __('modules.package.choosePackageType') }}" />
                            <x-select id="status" class="block w-full mt-1" wire:model.live="packageType">
                                @foreach($packageTypes as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                @endforeach
                            </x-select>
                            <x-input-error for="packageType" class="mt-2" />
                        </div>
                    @endif

                    @if($packageType->isEditable())
                        <div class="grid grid-cols-2 mt-4">
                            <x-label for="isRecommended">
                                <div class="flex items-center cursor-pointer">
                                    <x-checkbox name="isRecommended" id="isRecommended" wire:model="isRecommended" />
                                    <div class="select-none ms-2">
                                        @lang('modules.package.isRecommended')
                                    </div>
                                </div>
                            </x-label>

                            <x-label for="isPrivate">
                                <div class="flex items-center cursor-pointer">
                                    <x-checkbox name="isPrivate" id="isPrivate" wire:model="isPrivate" />
                                    <div class="select-none ms-2">
                                        @lang('modules.package.isPrivate')
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    @if($packageType != App\Enums\PackageType::TRIAL)
                        <div class="mt-4">
                            <x-label for="sortOrder" value="Sort Order" />
                            <x-select id="sortOrder" class="block w-full mt-1" wire:model="sortOrder">
                                @foreach (range(1, $maxOrder) as $i)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endforeach
                            </x-select>
                            <x-input-error for="sortOrder" />
                        </div>
                    @endif

                    @if(!$isFree)
                        <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700" />

                        <div class="mt-4">
                            <x-label for="currencyID" value="{{ __('modules.package.currency') }}" />
                            <x-select id="currencyID" class="block readonly w-full mt-1" wire:model.live="currencyID" disabled>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->currency_symbol }} ({{ $currency->currency_code }})</option>
                                @endforeach
                            </x-select>
                            <x-input-error for="currencyID" class="mt-2" />
                        </div>

                        @if($packageType == App\Enums\PackageType::LIFETIME)
                            <div class="mt-4">
                                <x-label for="price" value="{{ __('Life Time Plan Price ') . ' (' . $currencySymbol . ') '  }}" />
                                <x-input id="price" class="block w-full mt-1" type="number" min="0" wire:model="price" />
                                <x-input-error for="price" class="mt-2" />
                            </div>
                        @else
                            <div class="grid grid-cols-2 mt-4 gap-x-3 md:gap-x-5">
                                <x-label for="monthlyStatus">
                                    <div class="flex items-center cursor-pointer">
                                        <x-checkbox name="monthlyStatus" id="monthlyStatus" wire:model.live="monthlyStatus" />
                                        <div class="select-none ms-2">
                                            @lang('modules.package.monthlyPlan')
                                        </div>
                                    </div>
                                </x-label>

                                <x-label for="annualStatus">
                                    <div class="flex items-center cursor-pointer">
                                        <x-checkbox name="annualStatus" id="annualStatus" wire:model.live="annualStatus" />
                                        <div class="select-none ms-2">
                                            @lang('modules.package.annualPlan')
                                        </div>
                                    </div>
                                </x-label>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                            @if($monthlyStatus)
                                <div class="{{ $annualStatus ? 'col-span-1' : 'col-span-2' }} transition-all space-y-4">
                                    <div>
                                        <x-label for="monthlyPrice"
                                            value="{{ __('modules.package.monthlyPrice') . ' (' . $currencySymbol . ') ' }}" required="true" />
                                        <x-input id="monthlyPrice" class="block w-full mt-1" step="0.01" type="number" min="0" wire:model="monthlyPrice" />
                                        <x-input-error for="monthlyPrice" class="mt-2" />
                                    </div>
                                    @if($paymentKey->stripe_status == 1)
                                        <div>
                                            <x-label for="stripeMonthlyPlanId"
                                                value="{{ __('modules.package.monthlyStripeId') }}" required="true" />
                                            <x-input id="stripeMonthlyPlanId" class="block w-full mt-1" type="text" min="0" wire:model="stripeMonthlyPlanId" />
                                            <x-input-error for="stripeMonthlyPlanId" class="mt-2" />
                                        </div>
                                    @endif

                                    @if($paymentKey->razorpay_status == 1)
                                        <div>
                                            <x-label for="razorpayMonthlyPlanId"
                                                value="{{ __('modules.package.monthlyRazorpayId') }}" required="true" />
                                            <x-input id="razorpayMonthlyPlanId" class="block w-full mt-1" type="text" min="0" wire:model="razorpayMonthlyPlanId" />
                                            <x-input-error for="razorpayMonthlyPlanId" class="mt-2" />
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if($annualStatus)
                                <div class="{{ $monthlyStatus ? 'col-span-1' : 'col-span-2' }} transition-all space-y-4">
                                    <div>
                                        <x-label for="annualPrice"
                                            value="{{ __('modules.package.annualPrice') . ' (' . $currencySymbol . ') ' }}" required="true"/>
                                        <x-input id="annualPrice" class="block w-full mt-1" step="0.01" type="number" min="0" wire:model="annualPrice" />
                                        <x-input-error for="annualPrice" class="mt-2" />
                                    </div>
                                    @if($paymentKey->stripe_status == 1)
                                        <div>
                                            <x-label for="stripeAnnualPlanId"
                                                value="{{ __('modules.package.annualStripeId') }}" required="true"/>
                                            <x-input id="stripeAnnualPlanId" class="block w-full mt-1" type="text" min="0" wire:model="stripeAnnualPlanId" />
                                            <x-input-error for="stripeAnnualPlanId" class="mt-2" />
                                        </div>
                                    @endif
                                    @if($paymentKey->razorpay_status == 1)
                                        <div>
                                            <x-label for="razorpayAnnualPlanId"
                                                value="{{ __('modules.package.annualRazorpayId') }}" required="true" />
                                            <x-input id="razorpayAnnualPlanId" class="block w-full mt-1" type="text" min="0" wire:model="razorpayAnnualPlanId" />
                                            <x-input-error for="razorpayAnnualPlanId" class="mt-2" />
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($packageType == App\Enums\PackageType::TRIAL)
                        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                            <div class="mt-4">
                                <x-label for="trialStatus" value="{{ __('modules.package.trialStatus') }}" />
                                <x-select id="trialStatus" class="block w-full mt-1" wire:model="trialStatus">
                                    <option value="1">{{ __('app.active') }}</option>
                                    <option value="0">{{ __('app.inactive') }}</option>
                                </x-select>
                                <x-input-error for="trialStatus" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-label for="trialNotificationBeforeDays" value="{{ __('modules.package.NotificationBeforeDays') }}" />
                                <x-input id="trialNotificationBeforeDays" class="block w-full mt-1 " type="number" wire:model='trialNotificationBeforeDays' />
                                <x-input-error for="trialNotificationBeforeDays" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-label for="trialDays" value="{{ __('modules.package.trialDays') }}" />
                                <x-input id="trialDays" class="block w-full mt-1" type="number" wire:model='trialDays' />
                                <x-input-error for="trialDays" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-label for="trialMessage" value="{{ __('modules.package.trialMessage') }}" />
                                <x-input id="trialMessage" type="text" class="block w-full mt-1" wire:model='trialMessage' />
                                <x-input-error for="trialMessage" class="mt-2" />
                            </div>
                        </div>
                    @endif

                    <hr class="h-px my-5 bg-gray-200 border-0 dark:bg-gray-700">
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <x-label value="{{ __('modules.package.selectModules') }}" required="true" class="text-sm font-medium text-gray-700 dark:text-gray-300"/>
                            <label class="inline-flex items-center">
                                <x-checkbox wire:model.live="toggleSelectedModules"/>
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">@lang('modules.package.selectAll')</span>
                            </label>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach($modules as $module)
                                <label class="relative flex p-4 bg-white border rounded-lg cursor-pointer hover:border-primary-500 dark:border-gray-700 dark:bg-gray-800">
                                    <div class="flex items-center">
                                        <x-checkbox
                                            id="module_{{ $module->id }}"
                                            wire:model="selectedModules"
                                            value="{{ $module->id }}"
                                        />
                                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $module->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error for="selectedModules" class="mt-2" />
                    </div>

                    <!-- Additional Features -->
                    <div class="mt-6">
                        <x-label value="{{ __('modules.package.selectAdditionalFeature') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300"/>
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach($additionalFeatures as $feature)
                                <label class="relative flex p-4 bg-white border rounded-lg cursor-pointer hover:border-primary-500 dark:border-gray-700 dark:bg-gray-800">
                                    <div class="flex items-center">
                                        <x-checkbox
                                            id="feature_{{ $loop->index }}"
                                            wire:model.live="selectedFeatures"
                                            value="{{ $feature }}"
                                        />
                                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $feature }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    @if(in_array('Change Branch', $selectedFeatures))
                        <div class="mt-6">
                            <div class="rounded-md bg-yellow-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            @lang('modules.package.branchLimitInfo')
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="branch_limit" value="{{ __('modules.package.branchLimit') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300"/>
                                <x-input id="branch_limit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm" type="number" wire:model.live='branchLimit' />
                                <x-input-error for="branchLimit" class="mt-2" />
                            </div>
                        </div>
                    @endif

                    <div class="mt-2">
                        <x-label for="description" value="{{ __('modules.package.description') }}" required="true" class="text-sm font-medium text-gray-700 dark:text-gray-300"/>
                        <x-textarea id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm" wire:model='description' />
                        <x-input-error for="description" class="mt-2" />
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-6 flex items-center space-x-4">
                        <x-button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            @lang('app.save')
                        </x-button>

                        <x-secondary-link href="{{ route('superadmin.packages.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            @lang('app.cancel')
                        </x-secondary-link>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
