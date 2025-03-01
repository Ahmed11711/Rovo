<div class="w-full py-5 dark:bg-gray-800">
    <div class="bg-white dark:bg-gray-700 shadow-md border dark:border-gray-600 rounded-lg">
        <!-- Header Section -->
        <div class="border-b border-gray-200 dark:border-gray-600 px-6 py-2.5 flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 flex items-center">
                <svg class="h-6 w-6 mr-2 text-skin-base" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 13h16v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zM2 9h20v4H2zm10-4v17m0-16.5A3.5 3.5 0 1 0 8.5 9m7 0A3.5 3.5 0 1 0 12 5.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @lang('modules.billing.planDetails')
            </h4>
            <!-- Dropdown Button -->
            <x-dropdown align="right">
                <x-slot name="trigger">
                    <button type="button" class="inline-flex items-center px-2 py-2 border border-transparent rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01"/>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link wire:click="cancelSubscription(true)" class="text-red-600 dark:text-red-400">
                        @lang('modules.billing.cancelImmediately')
                    </x-dropdown-link>
                    <x-dropdown-link wire:click="cancelSubscription" class="text-yellow-500 dark:text-yellow-400">
                        @lang('modules.billing.endOfBillingCycle')
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <div class="p-6 space-y-6">
            <!-- Current Plan Name -->
            <div>
                <h5 class="text-gray-600 dark:text-gray-400 text-sm font-medium">@lang('modules.billing.currentPlan')</h5>
                <h3 class="text-xl font-bold text-skin-base mt-2">{{ $currentPackageName ?? __('modules.billing.noPlanAssigned') }}</h3>
            </div>

            <!-- Current Plan Type -->
            <div>
                <h5 class="text-gray-600 dark:text-gray-400 text-sm font-medium">@lang('modules.billing.currentPlanType')</h5>
                <h3 class="text-xl font-bold text-skin-base mt-2">{{ $currentPackageType ?? __('modules.billing.noPlanAssigned') }}</h3>
            </div>

            <!-- Current Plan Additional Features -->
            <div>
                <h5 class="text-gray-600 dark:text-gray-400 text-sm font-medium">@lang('modules.package.additionalFeatures')</h5>
                <ul class="mt-3 grid gap-4">
                    @foreach($currentPackageFeatures as $feature)
                        <li class="flex items-center text-gray-600 dark:text-gray-300 text-sm font-semibold">
                            <svg class="w-4 h-4 text-emerald-500 me-2" viewBox="0 0 24 24" fill="none">
                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- License Expire On (Work In Progress) -->
            <div>
                <h5 class="text-gray-600 dark:text-gray-400 text-sm font-medium">@lang('modules.billing.licenseExpireOn')</h5>
                <h3 class="text-lg text-skin-base mt-2">
                    @if($licenseExpireOn)
                        @php
                            $expiryDate = Carbon\Carbon::parse($licenseExpireOn);
                            $daysLeft = now()->startOfDay()->diffInDays($expiryDate->startOfDay(), false);
                            $status = $daysLeft > 0 ? $daysLeft . ' ' . trans_choice('modules.billing.daysLeft', $daysLeft) :
                                    ($daysLeft == 0 ? __('modules.billing.expiringToday') : __('modules.billing.expired'));
                        @endphp
                        {{ $expiryDate->translatedFormat('d F, Y') . ' (' . $status . ')' }}
                    @else
                        @lang('modules.billing.noPlanAssigned')
                    @endif
                </h3>
            </div>


            <!-- Upgrade Button -->
            <div>
                <a href="{{ route('pricing.plan') }}" wire:navigate>
                    <x-button class="inline-flex items-center shadow-md hover:origin-center group">
                        <svg class="w-5 h-5 text-current group-hover:scale-110 duration-500" width="24" height="24" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                            <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828z"/>
                        </svg>
                        @lang('modules.settings.upgradeLicense')
                    </x-button>
                </a>
            </div>
        </div>
    </div>
</div>
