<div>
    <div
        class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <h3 class="text-xl font-semibold dark:text-white">@lang('modules.settings.receiptSetting')</h3>
            </div>

        </div>

        <form wire:submit="submitForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div class="space-y-6">
                    {{-- Customer Information --}}
                    <div
                        class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white">@lang('modules.settings.customerInformation')</h4>

                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-checkbox name="customerName" id="customerName" wire:model='customerName' />
                                <label for="customerName" class="ms-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 me-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">@lang('modules.settings.customerName')</span>
                                </label>
                            </div>

                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-checkbox name="customerAddress" id="customerAddress" wire:model='customerAddress' />
                                <label for="customerAddress" class="ms-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 me-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">@lang('modules.settings.customerAddress')</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Order Details --}}
                    <div
                        class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white">@lang('modules.settings.orderDetails')</h4>

                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-checkbox name="tableNumber" id="tableNumber" wire:model='tableNumber' />
                                <label for="tableNumber" class="ms-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 me-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">@lang('modules.settings.tableNumber')</span>
                                </label>
                            </div>

                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-checkbox name="waiter" id="waiter" wire:model='waiter' />
                                <label for="waiter" class="ms-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 me-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">@lang('modules.settings.waiter')</span>
                                </label>
                            </div>

                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-checkbox name="totalGuest" id="totalGuest" wire:model='totalGuest' />
                                <label for="totalGuest" class="ms-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 me-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">@lang('modules.settings.totalGuest')</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                    {{-- Restaurant Information --}}
                    <div
                        class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white">@lang('modules.settings.restaurantInformation')</h4>

                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-checkbox name="restaurantLogo" id="restaurantLogo" wire:model='restaurantLogo' />
                                <label for="restaurantLogo" class="ms-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 me-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">@lang('modules.settings.restaurantLogo')</span>
                                </label>
                            </div>

                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-checkbox name="restaurantTax" id="restaurantTax" wire:model='restaurantTax' />
                                <label for="restaurantTax" class="ms-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 me-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">@lang('modules.settings.restaurantTax')</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Details --}}
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700" x-data="{ qrCodePreview: @entangle('paymentQrCode').defer }">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white">@lang('modules.settings.paymentDetails')</h4>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center space-x-6">
                                {{-- QR Code Preview --}}
                                <div class="flex-shrink-0">
                                    <div class="relative h-24 w-24">
                                        {{-- Current QR Code --}}
                                        <div x-show="!qrCodePreview"
                                            class="h-24 w-24 rounded-lg bg-gray-50 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                            @if ($paymentQrCode)
                                                <img src="{{ $paymentQrCode }}" alt="QR Code"
                                                    class="h-24 w-24 object-contain">
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400">No QR Code</span>
                                            @endif
                                        </div>

                                        {{-- New QR Code Preview --}}
                                        <div x-show="qrCodePreview" style="display: none;">
                                            <span class="block h-24 w-24 rounded-lg bg-cover bg-center bg-no-repeat"
                                                x-bind:style="'background-image: url(' + qrCodePreview + ');'"></span>
                                        </div>

                                        {{-- Loading State --}}
                                        <div wire:loading wire:target="paymentQrCode"
                                            class="absolute inset-0 bg-gray-900/60 rounded-lg flex items-center justify-center">
                                            <svg class="animate-spin h-6 w-6 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
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
                                    <input type="file" id="paymentQrCode" class="hidden" accept="image/*" wire:model="paymentQrCode" x-ref="paymentQrCode"
                                        x-on:change="qrCodeName = $refs.paymentQrCode.files[0].name; const reader = new FileReader(); reader.onload = (e) => { qrCodePreview = e.target.result; };reader.readAsDataURL($refs.paymentQrCode.files[0]);" />

                                    <div class="flex flex-wrap gap-3">
                                        <x-secondary-button type="button"
                                            x-on:click.prevent="$refs.paymentQrCode.click()"
                                            class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            {{ __('modules.settings.uploadPaymentQrCode') }}
                                        </x-secondary-button>
                                    </div>

                                    <x-input-error for="paymentQrCode" class="mt-2" />
                                </div>
                            </div>

                            {{-- Show/Hide QR Code Option --}}
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-checkbox name="showPaymentQrCode" id="showPaymentQrCode"
                                    wire:model='showPaymentQrCode' />
                                <label for="showPaymentQrCode" class="ms-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 me-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">@lang('modules.settings.showPaymetQrCode')</span>
                                </label>
                            </div>

                        </div>
                    </div>

                    {{-- Submit Button  --}}
                    <div class="flex justify-end gap-2 ">
                        <div x-data="{ showPreview: false }">
                            <x-secondary-button class="inline-flex items-center" @click="showPreview = true">
                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                @lang('modules.settings.previewReceipt')
                            </x-secondary-button>

                            {{-- Receipt Preview Modal --}}
                            <div x-show="showPreview" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
                                aria-modal="true" x-cloak>
                                <div
                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showPreview"
                                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                        @click="showPreview = false">
                                    </div>

                                    <div x-show="showPreview"
                                        class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <h3 class="text-lg font-medium">@lang('modules.settings.receiptPreview')</h3>
                                                <button type="button" @click="showPreview = false"
                                                    class="text-gray-400 hover:text-gray-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            {{-- Receipt Preview Content --}}
                                            <div class="receipt" style="width: 80mm; margin: 0 auto;">
                                                <div class="header">
                                                    <div class="restaurant-name">
                                                        @if ($restaurantLogo)
                                                            <span>
                                                                <img src="{{ restaurant()->logo_url }}"
                                                                    alt="{{ restaurant()->name }}"
                                                                    class="restaurant-logo"
                                                                    style="width: 20px; height: 20px; margin-top: 3px;">
                                                            </span>
                                                        @endif
                                                        <span>{{ restaurant()->name }}</span>
                                                    </div>
                                                    <div class="restaurant-info">{{ restaurant()->address }}</div>
                                                    <div class="restaurant-info">@lang('modules.customer.phone'):
                                                        {{ restaurant()->phone_number }}</div>
                                                    @if ($restaurantTax)
                                                        <div class="restaurant-info">Tax ID: SAMPLE-TAX-ID</div>
                                                    @endif
                                                </div>

                                                <div class="order-info">
                                                    <div class="summary-row">
                                                        <span>@lang('modules.order.orderNumber') #<span
                                                                class="order-number">SAMPLE-001</span></span>
                                                        <span>{{ now()->format('D, d M Y, H:i') }}</span>
                                                    </div>

                                                    <div class="summary-grid">
                                                        @if ($tableNumber)
                                                            <span>@lang('modules.settings.tableNumber'): 01</span>
                                                        @endif
                                                        @if ($totalGuest)
                                                            <span>@lang('modules.order.noOfPax'): 2</span>
                                                        @endif
                                                    </div>

                                                    @if ($waiter)
                                                        <div class="summary-row">
                                                            <span>@lang('modules.order.waiter'): John Smith</span>
                                                        </div>
                                                    @endif

                                                    @if ($customerName)
                                                        <div class="summary-row">
                                                            <span>@lang('modules.customer.customer'): Jane Doe</span>
                                                        </div>
                                                    @endif

                                                    @if ($customerAddress)
                                                        <div class="summary-row">
                                                            <span>@lang('modules.customer.customerAddress'): 123 Sample Street</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <table class="items-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="qty">@lang('modules.order.qty')</th>
                                                            <th class="description">@lang('modules.menu.itemName')</th>
                                                            <th class="price">@lang('modules.order.price')</th>
                                                            <th class="amount">@lang('modules.order.amount')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="qty">2</td>
                                                            <td class="description">Sample Item 1</td>
                                                            <td class="price">{{ currency_format(10) }}</td>
                                                            <td class="amount">{{ currency_format(20) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="qty">1</td>
                                                            <td class="description">Sample Item 2</td>
                                                            <td class="price">{{ currency_format(15) }}</td>
                                                            <td class="amount">{{ currency_format(15) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div class="summary">
                                                    <div class="summary-row">
                                                        <span>@lang('modules.order.subTotal'):</span>
                                                        <span>{{ currency_format(35) }}</span>
                                                    </div>

                                                    @if ($restaurantTax)
                                                        <div class="summary-row">
                                                            <span>Tax (10%):</span>
                                                            <span>{{ currency_format(3.5) }}</span>
                                                        </div>
                                                    @endif

                                                    <div class="summary-row total">
                                                        <span>@lang('modules.order.total'):</span>
                                                        <span>{{ currency_format(38.5) }}</span>
                                                    </div>
                                                </div>

                                                <div class="footer">
                                                    <p>@lang('messages.thankYouVisit')</p>

                                                        @if ($showPaymentQrCode)
                                                            <p class="mt-4" >@lang('modules.settings.payFromYourPhone')</p>

                                                            <img class="qr_code" src="{{ $paymentQrCode }}"
                                                                alt="QR Code">
                                                            <p class="">@lang('modules.settings.scanQrCode')</p>
                                                        @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Save Button --}}
                        <div class="flex justify-end">
                            <x-button>
                                @lang('app.save')
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .receipt {
            padding: 6.35mm;
            page-break-after: always;
        }

        .header {
            text-align: center;
            margin-bottom: 3mm;
        }

        .restaurant-name {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .restaurant-info {
            font-size: 9pt;
            margin-bottom: 1mm;
        }

        .order-info {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 2mm 0;
            margin-bottom: 3mm;
            font-size: 9pt;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
            font-size: 9pt;
        }

        .items-table th {
            text-align: left;
            padding: 1mm;
            border-bottom: 1px solid #000;
        }

        .items-table td {
            padding: 1mm 0;
            vertical-align: top;
        }

        .qty {
            width: 10%;
            text-align: center;
        }

        .description {
            width: 50%;
        }

        .price {
            width: 20%;
            text-align: right;
        }

        .amount {
            width: 20%;
            text-align: right;
        }

        .summary {
            font-size: 9pt;
            margin-top: 2mm;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            justify-content: space-between;
            gap: 5px 55px;
            margin-bottom: 1mm;
        }

        .total {
            font-weight: bold;
            font-size: 11pt;
            border-top: 1px solid #000;
            padding-top: 1mm;
            margin-top: 1mm;
        }

        .footer {
            text-align: center;
            margin-top: 3mm;
            font-size: 9pt;
            padding-top: 2mm;
            border-top: 1px dashed #000;
        }

        .qr_code {
            margin-top: 5mm;
            margin-bottom: 3mm;
            margin-left: 13mm;
        }
    </style>
</div>
