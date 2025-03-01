<div>
    @assets
    <script src="{{ asset('vendor/pikaday.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/pikaday.css') }}">
    @endassets

    @if($latestSubscription)
    <div class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">@lang('modules.package.restaurantCurrentPackage')</div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="font-semibold text-gray-700 dark:text-gray-300">{{ __('modules.package.packageDetails') }}</div>
        <div>{{ $latestSubscription->package_name}}</div>

        <div class="font-semibold text-gray-700 dark:text-gray-300">{{ __('modules.package.packageType') }}</div>
        <div> {{ $latestSubscription->package_type }}</div>

        <div class="font-semibold text-gray-700 dark:text-gray-300">{{ __('modules.package.amount') }}</div>
        <div>{{ $latestSubscription?->currency?->currency_symbol }}{{ number_format($latestSubscription?->currentInvoice->total, 2) }}</div>

        <div class="font-semibold text-gray-700 dark:text-gray-300">{{ __('modules.package.paymentDate') }}</div>
        <div>{{ $latestSubscription->currentInvoice->pay_date ? \Carbon\Carbon::parse($latestSubscription->currentInvoice->pay_date)->format('d-m-Y') : '--' }}</div>

        <div class="font-semibold text-gray-700 dark:text-gray-300">{{ __('modules.package.nextPaymentDate') }}</div>
        <div>{{ $latestSubscription->currentInvoice->next_pay_date ? $latestSubscription->currentInvoice->next_pay_date->format('d-m-Y') : '--' }}</div>

        <div class="font-semibold text-gray-700 dark:text-gray-300">{{ __('modules.package.licenseExpiresOn') }}</div>
        <div>{{ $latestSubscription->license_expire_on ? $latestSubscription->license_expire_on->format('d-m-Y') : '--' }}</div>
    </div>
    @endif

    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700" />

    <form wire:submit="updatePackageSubmit" class="space-y-4">
        <h2 class="text-xl font-bold">{{ __('modules.package.updatePackage') }}</h2>

        <!-- Package Selection -->
        <div>
            <x-label for="package" value="{{ __('modules.package.selectPackage') }}" />
            <x-select id="package" class="mt-1 w-full" wire:model.live="packageId">
                @foreach($packages as $package)
                <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                @endforeach
            </x-select>
            <x-input-error for="packageId" class="mt-2" />
        </div>

        <!-- Billing Cycle Selection -->
        @if($packageType)
        <div>
            <x-label for="billing_cycle" value="{{ __('modules.package.selectBillingCycle') }}" />
            <x-select id="billing_cycle" class="mt-1 w-full" wire:model.live="billingCycle">
                @if($selectedPackage->is_free)
                    @if($selectedPackage->package_type === App\Enums\PackageType::TRIAL)
                        <option value="trial">
                            {{ __('modules.package.trial') }} ({{ $selectedPackage->trial_status ? __('modules.package.active') : __('modules.package.inactive') }})
                        </option>
                    @else
                        <option value="free">{{ __('modules.package.free') }}</option>
                    @endif
                @endif

                @if($selectedPackage->package_type === App\Enums\PackageType::LIFETIME)
                <option value="lifetime">
                    {{ __('modules.package.lifetime') }} - {{ $selectedPackage?->currency?->currency_symbol }}{{ $selectedPackage?->price }}
                </option>
                @endif

                @if($packageMonthlyStatus)
                <option value="monthly">
                    {{ __('modules.package.monthly') }} - {{ $selectedPackage?->currency?->currency_symbol }}{{ $monthlyPrice }}
                </option>
                @endif

                @if($packageAnnualStatus)
                <option value="annual">
                    {{ __('modules.package.annual') }} - {{ $selectedPackage?->currency?->currency_symbol }}{{ $annualPrice }}
                </option>
                @endif
            </x-select>
            <x-input-error for="billingCycle" class="mt-2" />
        </div>
        @endif

        @if($packageType === App\Enums\PackageType::TRIAL)
            <div>
                <x-label for="trial_expire_on" value="{{ __('modules.package.trialExpireOn') }}" />
                <x-datepicker id="trial_expire_on" class="w-full mt-1" wire:model="trialExpireOn" autocomplete="off" placeholder="{{ __('modules.package.selectDate') }}" />
                <x-input-error for="trialExpireOn" class="mt-2" />
            </div>
        @else
            <div>
                <x-label for="amount" value="{{ __('modules.package.amount') }}" />
                <x-input id="amount" type="number" class="mt-1 w-full" wire:model="amount" />
                <x-input-error for="amount" class="mt-2" />
            </div>

            <div>
                <x-label for="pay_date" value="{{ __('modules.package.paymentDate') }}" />
                <x-datepicker id="pay_date" class="w-full mt-1" wire:model="payDate" autocomplete="off" placeholder="{{ __('modules.package.selectDate') }}" />
                <x-input-error for="payDate" class="mt-2" />
            </div>

            <div>
                <x-label for="next_pay_date" value="{{ __('modules.package.nextPaymentDate') }}" />
                <x-datepicker id="next_pay_date" class="w-full mt-1" wire:model="nextPayDate" autocomplete="off" placeholder="{{ __('modules.package.selectDate') }}" />
                <x-input-error for="nextPayDate" class="mt-2" />
            </div>

            <div>
                <x-label for="licence_expires_on" value="{{ __('modules.package.licenceExpiresOn') }}" />
                <x-datepicker id="licence_expires_on" class="w-full mt-1" wire:model="licenceExpireOn" autocomplete="off" placeholder="{{ __('modules.package.selectDate') }}" />
                <x-input-error for="licenceExpireOn" class="mt-2" />
            </div>
        @endif

        <!-- Submit Button -->
        <x-button wire:target='updatePackageSubmit' wire:loading.attr='disabled'>
            {{ __('modules.package.updatePackage') }}
        </x-button>
    </form>

</div>
