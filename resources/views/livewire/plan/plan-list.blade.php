<div>
    <section class="text-gray-700 body-font overflow-hidden p-8 border-gray-200 dark:border-gray-700">

        <div class="flex justify-between items-center px-7 py-4">
            <div class="flex space-x-2">
                <!-- Monthly Button -->
                <button wire:click="toggle"
                    @class([ 'relative px-4 py-2 text-sm font-medium rounded-full transition-colors duration-200 ease-in-out'
                    , 'bg-skin-base text-white'=> !$isAnnual,
                    'bg-gray-200 dark:bg-gray-400 text-gray-800' => $isAnnual
                    ])>
                    @lang('modules.billing.monthly')
                </button>

                <!-- Annually Button -->
                <button wire:click="toggle"
                    @class([ 'relative px-4 py-2 text-sm font-medium rounded-full transition-colors duration-200 ease-in-out'
                    , 'bg-skin-base text-white'=> $isAnnual,
                    'bg-gray-200 dark:bg-gray-400 text-gray-800' => !$isAnnual
                    ])>
                    @lang('modules.billing.annually')
                </button>
            </div>



            <!-- Currency Dropdown with Animation -->
        <x-select  class="mt-1 block" wire:model.live="selectedCurrency">
            @foreach ($currencies as $currency)
                <option value="{{ $currency->id }}">{{ $currency->currency_name }} ({{ $currency->currency_symbol }})</option>
            @endforeach
        </x-select>
        </div>


        <div class="grid grid-cols-1 bg-white dark:bg-slate-800 sm:grid-cols-2 md:grid-cols-3 gap-x-1 mx-4 p-2 lg:grid-cols-5">
            <div>
                <div class="text-center h-48 inline-flex items-center border-l border-t  w-full rounded-tl-lg border-gray-300 dark:border-gray-600 justify-center">
                    <h3 class="tracking-widest text-gray-900 text-2xl texr dark:text-white">@lang('modules.billing.pickYourPlan')</h3>
                </div>
                <div class="border-t border-gray-300 border-b border-l dark:border-gray-600 rounded-bl-lg overflow-hidden">
                    @foreach ($modules as $index => $module)
                    <p @class([ 'text-gray-900 dark:text-white h-12 text-center px-4 flex items-center justify-start',
                        'bg-gray-100 dark:bg-slate-900'=> $index % 2 == 0
                        ])>
                        {{ __('permissions.modules.'.$module->name) }}
                    </p>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-flow-col auto-cols-max md:col-span-2 lg:col-span-4 overflow-x-auto scrollbar-track-gray-200 scrollbar-thin">
                @foreach ($packages as $package)
                    <div @class([
                        'w-64 mb-6 border relative',
                        'border-skin-base shadow-inner' => $package->is_recommended,
                        'border-gray-300 dark:border-gray-600' => ! $package->is_recommended
                    ])>
                        @if ($package->is_recommended)
                            <span class="bg-skin-base text-white px-3 py-1 tracking-widest text-xs absolute right-0.5 top-0 rounded-bl">POPULAR</span>
                        @endif
                        <div class="px-2 text-center h-48 flex flex-col border-b border-gray-300 dark:border-gray-600 items-center justify-center">
                            <h3 class="tracking-widest text-xl font-semibold text-gray-900 dark:text-white">{{ $package->package_name }}</h3>
                            <h2 class="text-xl text-gray-900 dark:text-white font-medium leading-none mb-4 mt-2">
                                @if ($package->is_free)
                                    @lang('modules.billing.free')
                                @else
                                    {{ global_currency_format($package->package_type === App\Enums\packageType::LIFETIME ? $package->price : ($isAnnual ? $package->annual_price : $package->monthly_price), $package->currency_id) }}
                                @endif
                            </h2>
                            @if ($package->package_type === App\Enums\packageType::DEFAULT)
                                <span class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    @lang('modules.package.defaultPlan')
                                    <svg data-popover-target="popover-default-pricing" data-popover-placement="bottom" class="w-4 h-4 ms-1 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div data-popover id="popover-default-pricing" role="tooltip" class="absolute text-wrap z-10 invisible inline-block text-sm text-gray-600 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-52 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 break-words space-y-2">
                                            <p>@lang('modules.package.planExpire')</p>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>
                                </span>
                            @elseif ($package->package_type === App\Enums\packageType::LIFETIME)
                                <span class="text-sm text-gray-600 dark:text-gray-400">@lang('modules.billing.lifetimeAccess')</span>
                            @elseif (!$package->is_free)
                                <span class="text-sm text-gray-600 dark:text-gray-400">@lang('modules.billing.billed') {{ $isAnnual ? __('modules.billing.annually') : __('modules.billing.monthly') }}</span>
                            @endif
                        </div>
                        @foreach ($modules as $module)
                            <p @class(['text-center h-12 flex items-center justify-center', 'bg-gray-100 dark:bg-slate-900' => $loop->index % 2 == 0])>
                                @if ($package->modules->contains($module))
                                    <span class="w-5 h-5 inline-flex items-center justify-center bg-green-500 text-white rounded-full flex-shrink-0">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                            <path d="M20 6L9 17l-5-5"></path>
                                        </svg>
                                    </span>
                                @else
                                    <span class="w-5 h-5 inline-flex items-center justify-center text-red-500 flex-shrink-0">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path d="M18 6L6 18M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                @endif
                            </p>
                        @endforeach
                        @if ($package->is_free || $paymentActive ||
                            ($package->id == $restaurant->package_id && $restaurant->package_type == ($isAnnual ? 'annual' : 'monthly')) ||
                            $package->package_type == App\Enums\PackageType::DEFAULT)
                            <li class="border-t border-gray-300 dark:border-gray-600 flex justify-center items-center p-4 text-center">
                                @if($package->id == $restaurant->package_id && ($restaurant->package_type == ($isAnnual ? 'annual' : 'monthly') || !in_array($restaurant->package_type, ['annual', 'monthly'])))
                                    <x-button class="inline-flex items-center opacity-60 justify-center gap-2 w-full cursor-not-allowed transition-all duration-300">
                                        @lang('modules.package.currentPlan')
                                    </x-button>
                                @else
                                    <x-button class="inline-flex items-center justify-center gap-2 w-full transition-all duration-300 group"
                                        wire:click="selectedPackage({{ $package->id }})">
                                        @lang('modules.package.choosePlan')
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 transition-transform duration-500 transform group-hover:translate-x-1" viewBox="0 0 24 24"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                                    </x-button>
                                @endif
                            </li>
                        @else
                            <li class="border-t border-gray-300 dark:border-gray-600 flex justify-center items-center text-gray-900 dark:text-gray-400 p-4 text-center">
                                @lang('modules.billing.noPaymentOptionEnable')
                            </li>
                        @endif
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <x-dialog-modal wire:model.live="showPaymentMethodModal" maxWidth="xl">
        <x-slot name="title">
            @if($free)
                @lang('modules.billing.choosePlan')
            @else
                @lang('modules.billing.choosePaymentMethod')
            @endif
        </x-slot>

        <x-slot name="content">
            @if(!$free)
                <div>
                    @switch($show)
                        @case('payment-method')
                            @include('plans.payment-methods')
                            @break
                        @case('authorize')
                            @include('plans.authorize-payment-method-form')
                            @break
                        @default
                            <!-- Default case if no match -->
                            <p>@lang('modules.billing.noPaymentMethodSelected')</p>
                    @endswitch
                </div>
            @else
                <div class="inline-flex items-baseline text-center text-gray-500">
                    <x-button wire:click="freePlan">

                        @lang($selectedPlan->packageType === App\Enums\PackageType::DEFAULT ? 'modules.package.choseDefaultPlan' : 'modules.package.choseFreePlan')
                    </x-button>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showPaymentMethodModal')" wire:loading.attr="disabled">
                @lang('app.cancel')
            </x-secondary-button>

            @if($offlineMethodId)
            <x-button class="ml-3" wire:click="{{ $show === 'authorize' ? 'offlinePaymentSubmit' : 'switchPaymentMethod(\'authorize\')' }}" wire:loading.attr="disabled">
                @lang($show === 'authorize' ? 'app.save' : 'app.select')
            </x-button>
            @endif
        </x-slot>
    </x-dialog-modal>

    @if(!$free)

    @if($stripeSettings->razorpay_status == 1 || $stripeSettings->stripe_status == 1)
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    @script
    <script>
        document.addEventListener('livewire:navigated', () => {
            $wire.on('initiateRazorpay', (jsonData) => {
                const data = JSON.parse(jsonData);
                const options = {
                    key: data.key,
                    subscription_id: data.subscription_id,
                    name: data.name,
                    description: data.description,
                    image: data.image,
                    currency: data.currency,
                    handler: function (response) {
                        $wire.dispatch('confirmRazorpayPayment', {
                            payment_id: response.razorpay_payment_id,
                            subscription_id: response.razorpay_subscription_id,
                            signature: response.razorpay_signature,
                        });
                    },
                    notes: data.notes,
                    "modal": {
                        "ondismiss": function() {
                            if (confirm("Are you sure, you want to close the form?")) {
                                txt = "You pressed OK!";
                                console.log("Checkout form closed by the user");
                            } else {
                                txt = "You pressed Cancel!";
                                console.log("Complete the Payment")
                            }
                        }
                    }
                };

                var rzp1 = new Razorpay(options);
                rzp1.on('payment.failed', function(response) {
                console.log(response);
                });
                rzp1.open();
            });

            $wire.on('stripePlanPaymentInitiated', (payment) => {
                console.log(payment.payment.id);

                document.getElementById('license_payment').value = payment.payment.id;
                document.getElementById('package_type').value = payment.payment.package_type;
                document.getElementById('package_id').value = payment.payment.package_id;
                document.getElementById('currency_id').value = payment.payment.currency_id;
                document.getElementById('license-payment-form').submit();
            });
        });
    </script>
    @endscript
    @endpush
    @endif
    @endif

</div>


