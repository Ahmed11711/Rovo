<div class="stripePaymentForm">
    @if($stripeSettings->stripe_status === 1)
    <div class="w-full">
        <form wire:submit="submitForm">
            @csrf
           

            @if(!$isFree)
            <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700" />

            <div class="mt-4">
                <x-label for="currencyID" value="{{ __('Currency') }}" />
                <x-select id="currencyID" class="mt-1 block w-full" wire:model.live="currencyID">
                    @foreach($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->currency_symbol }} ({{ $currency->currency_code }})
                    </option>
                    @endforeach
                </x-select>
                <x-input-error for="currencyID" class="mt-2" />
            </div>

            @if($packageType == App\Enums\PackageType::LIFETIME)
            <div class="mt-4">
                <x-label for="price" value="{{ __('Life Time Plan Price ') . ' (' . $currencySymbol . ') '  }}" />
                <x-input id="price" class="block mt-1 w-full" type="number" min="0" wire:model="price" />
                <x-input-error for="price" class="mt-2" />
            </div>
            @else
            <div class="grid gap-x-3 md:gap-x-5 grid-cols-2 mt-4">
                <x-label for="monthlyStatus">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="monthlyStatus" id="monthlyStatus" wire:model.live="monthlyStatus" />
                        <div class="ms-2 select-none">
                            @lang('modules.package.monthlyPlan')
                        </div>
                    </div>
                </x-label>

                <x-label for="annualStatus">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="annualStatus" id="annualStatus" wire:model.live="annualStatus" />
                        <div class="ms-2 select-none">
                            @lang('modules.package.annualPlan')
                        </div>
                    </div>
                </x-label>
            </div>
            @endif

            <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                @if($monthlyStatus)
                <div class="{{ $annualStatus ? 'col-span-1' : 'col-span-2' }} transition-all">
                    <x-label for="monthlyPrice"
                         value="{{ __('modules.package.monthlyPrice') . ' (' . $currencySymbol . ') ' }}" />
                    <x-input id="monthlyPrice" class="block mt-1 w-full" type="number" min="0" wire:model="monthlyPrice" />
                    <x-input-error for="monthlyPrice" class="mt-2" />
                </div>
                @endif

                @if($annualStatus)
                <div class="{{ $monthlyStatus ? 'col-span-1' : 'col-span-2' }} transition-all">
                    <x-label for="annualPrice"
                         value="{{ __('modules.package.annualPrice') . ' (' . $currencySymbol . ') ' }}" />
                    <x-input id="annualPrice" class="block mt-1 w-full" type="number" min="0" wire:model="annualPrice" />
                    <x-input-error for="annualPrice" class="mt-2" />
                </div>
                @endif
            </div>

            @endif

            @if ($packageType == App\Enums\PackageType::TRIAL)
            <div class="mt-4">
                <x-label for="trialDays" value="{{ __('Trial Days') }}" />
                <x-input id="trialDays" class="block mt-1 w-full" type="number" wire:model='trialDays' />
                <x-input-error for="trialDays" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="trialStatus" value="{{ __('Trial Status') }}" />
                <x-select id="trialStatus" class="mt-1 block w-full" wire:model="trialStatus">
                    <option value="1">{{ __('Active') }}</option>
                    <option value="0">{{ __('Inactive') }}</option>
                </x-select>
                <x-input-error for="trialStatus" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="trialNotificationBeforeDays" value="{{ __('Trial Before Days') }}" />
                <x-input id="trialNotificationBeforeDays" class="block mt-1 w-full " type="number" wire:model='trialNotificationBeforeDays' />
                <x-input-error for="trialNotificationBeforeDays" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="trialMessage" value="{{ __('Trial Message') }}" />
                <x-input id="trialMessage" type="text" class="block mt-1 w-full" wire:model='trialMessage' />
                <x-input-error for="trialMessage" class="mt-2" />
            </div>
            @endif
            <div class="lg:flex items-center justify-between mt-4 gap-2">
                <x-button wire:click="submitForm" type="button">
                    {{ __('Next: Package Modules') }}
                </x-button>
            </div>
        </form>
    </div>
    @endif
</div>
