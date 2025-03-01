<x-dialog-modal wire:model.live="showAddPaymentModal" maxWidth="4xl">
    <x-slot name="title">
        @if($order)

        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="text-xl font-semibold">{{ __('modules.order.payment') }}</h2>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-lg font-medium">{{ __('modules.order.orderHash') }}{{ $order->order_number }}</span>
                <span class="text-xl font-bold text-skin-base">{{ currency_format($order->total) }}</span>
            </div>
        </div>
        @endif
    </x-slot>

    <x-slot name="content">
        @if($order)

        <div x-data="{
            showSplitOptions: false,
            splitType: null,
            numberOfSplits: 2,
            customSplits: [1, 2],
            splits: [{ id: 1, items: [] }],
            activeSplitId: 1
        }" class="relative" style="min-height: 500px">
            <!-- Regular Payment View -->
            <div x-show="!showSplitOptions" class="flex gap-4">
                <!-- Left Side - Payment Options -->
                <div class="flex-1">
                    <!-- Payment Type Selector -->
                    <div class="flex gap-3 mb-4">
                        <button class="flex-1 py-2 px-3 text-center border rounded-lg bg-skin-base text-white text-sm" @click="showSplitOptions = false">
                            {{ __('modules.order.fullPayment') }}
                        </button>
                        <button class="flex-1 py-2 px-3 text-center border rounded-lg hover:bg-gray-50 text-sm" wire:click="showSplitOptions = true" @click="showSplitOptions = true">
                            {{ __('modules.order.splitBill') }}
                        </button>
                    </div>

                    <!-- Payment Methods -->
                    <div class="grid grid-cols-4 gap-3">
                        <button wire:click="setPaymentMethod('cash')"
                            class="p-3 text-center border rounded-lg {{ $paymentMethod === 'cash' ? 'bg-skin-base/5 border-skin-base' : 'hover:bg-gray-50' }}">
                            <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-sm">@lang('modules.order.cash')</span>
                        </button>

                        <button wire:click="setPaymentMethod('card')"
                            class="p-3 text-center border rounded-lg {{ $paymentMethod === 'card' ? 'bg-skin-base/5 border-skin-base' : 'hover:bg-gray-50' }}">
                            <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span class="text-sm">@lang('modules.order.card')</span>
                        </button>

                        <button wire:click="setPaymentMethod('upi')"
                            class="p-3 text-center border rounded-lg {{ $paymentMethod === 'upi' ? 'bg-skin-base/5 border-skin-base' : 'hover:bg-gray-50' }}">
                            <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm">@lang('modules.order.upi')</span>
                        </button>

                        <button wire:click="setPaymentMethod('due')"
                            class="p-3 text-center border rounded-lg {{ $paymentMethod === 'due' ? 'bg-skin-base/5 border-skin-base' : 'hover:bg-gray-50' }}">
                            <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm">@lang('modules.order.due')</span>
                        </button>
                    </div>

                    <!-- Amount Input and Summary -->
                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm mb-1">{{ __('modules.order.amount') }}</label>
                            <input type="number" wire:model.live="paymentAmount"
                                class="w-full text-2xl p-3 rounded-lg border-gray-300"
                                {{ $paymentMethod !== 'cash' ? 'readonly' : '' }}>
                        </div>

                        <div class="hidden">
                            <label class="block text-sm mb-1">{{ __('modules.order.returnAmount') }}</label>
                            <div class="w-full text-2xl p-3 rounded-lg border-gray-300 bg-gray-100 ">
                                {{ currency_format($returnAmount, restaurant()->currency_id) }}
                            </div>
                        </div>

                @if ($order)
                        <!-- Payment Summary -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>{{ __('modules.order.totalBill') }}</span>
                                    <span class="font-medium">{{ currency_format($order->total) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>{{ __('modules.order.amountPaid') }}</span>
                                    <span class="font-medium">{{ currency_format($paidAmount) }}</span>
                                </div>
                                @if($paymentMethod === 'cash')
                                    @if($returnAmount > 0)
                                    <div class="flex justify-between text-green-600 pt-2 border-t">
                                        <span>{{ __('modules.order.returnAmount') }}</span>
                                        <span class="font-medium">{{ currency_format($returnAmount) }}</span>
                                    </div>
                                    @else
                                    <div class="flex justify-between text-red-600 pt-2 border-t">
                                        <span>{{ __('modules.order.dueAmount') }}</span>
                                        <span class="font-medium">{{ currency_format($balanceAmount) }}</span>
                                    </div>
                                    @endif
                                @else
                                    <div class="flex justify-between text-gray-600 pt-2 border-t">
                                        <span>{{ __('modules.order.dueAmount') }}</span>
                                        <span class="font-medium">{{ currency_format($balanceAmount) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                <!-- Right Side - Numpad -->
                <div class="w-72">
                    <!-- Quick Amount Buttons -->
                    <div class="grid grid-cols-2 gap-2 mb-3">
                        @foreach([50, 100, 500, 1000] as $amount)
                        <button wire:click="quickAmount({{ $amount }})" class="p-2 text-center border rounded-lg hover:bg-gray-50">
                            <span class="font-medium">{{ currency_format($amount) }}</span>
                        </button>
                        @endforeach
                    </div>

                    <!-- Numpad -->
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(range(1, 9) as $number)
                        <button wire:click="appendNumber('{{ $number }}')" class="p-4 text-center border rounded-lg hover:bg-gray-50">
                            <span class="text-xl">{{ $number }}</span>
                        </button>
                        @endforeach
                        <button wire:click="appendNumber('.')" class="p-4 text-center border rounded-lg hover:bg-gray-50">
                            <span class="text-xl">.</span>
                        </button>
                        <button wire:click="appendNumber('0')" class="p-4 text-center border rounded-lg hover:bg-gray-50">
                            <span class="text-xl">0</span>
                        </button>
                        <button wire:click="clearAmount" class="p-4 text-center border rounded-lg hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Split Bill Options -->
            <div x-show="showSplitOptions"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="absolute inset-0 bg-white dark:bg-gray-800 rounded-lg flex flex-col">

                <!-- Header - Fixed -->
                <div class="p-4 border-b bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-semibold">{{ __('modules.order.splitBill') }}</h3>
                            <template x-if="splitType">
                                <button @click="splitType = null" class="text-sm text-gray-500 hover:text-gray-700">
                                    ({{ __('modules.order.changeMethod') }})
                                </button>
                            </template>
                        </div>
                        <button @click="showSplitOptions = false; splitType = null" wire:click="showSplitOptions = false;" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Content - Scrollable -->
                <div class="flex-1 overflow-y-auto p-4">
                    <!-- Split Methods Selection -->
                    <div x-show="!splitType" class="h-full grid grid-cols-3 gap-4 place-content-center">
                        <button @click="splitType = 'equal'" wire:click="splitType = 'equal'" class="p-4 text-center border rounded-lg hover:bg-gray-50">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="block font-medium">{{ __('modules.order.equalSplit') }}</span>
                            <span class="text-sm text-gray-500">{{ __('modules.order.splitEqually') }}</span>
                        </button>
                        <button @click="splitType = 'custom'" wire:click="splitType = 'custom'" class="p-4 text-center border rounded-lg hover:bg-gray-50">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="block font-medium">{{ __('modules.order.customSplit') }}</span>
                            <span class="text-sm text-gray-500">{{ __('modules.order.splitByAmount') }}</span>
                        </button>
                        <button @click="splitType = 'items'" wire:click="splitType = 'items'" class="p-4 text-center border rounded-lg hover:bg-gray-50">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="block font-medium">{{ __('modules.order.splitByItems') }}</span>
                            <span class="text-sm text-gray-500">{{ __('modules.order.splitByDishes') }}</span>
                        </button>
                    </div>

                    <!-- Equal Split Options -->
                    <div x-show="splitType === 'equal'" class="h-full flex flex-col">
                        <div class="flex items-center gap-2 border-b pb-4">
                            <div class="flex flex-wrap gap-2 flex-1">
                                @for($i = 1; $i <= $numberOfSplits; $i++)
                                    <div class="flex items-center gap-1">
                                        <div class="px-4 py-2 rounded-lg text-sm border">
                                            <span>Split {{ $i }}</span>
                                        </div>
                                        @if($numberOfSplits > 2)
                                            <button wire:click="removeSplit({{ $i }})"
                                                class="p-1 text-gray-400 hover:text-red-500 rounded-full hover:bg-gray-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                            <button wire:click="addNewSplit"
                                class="px-3 py-2 text-sm border rounded-lg hover:bg-gray-50 shrink-0">
                                + New Split
                            </button>
                        </div>
                        <div class="flex-1 grid grid-cols-2 gap-4 content-start">
                            @for($i = 1; $i <= $numberOfSplits; $i++)
                                <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                    <div class="flex-1 flex justify-between items-center gap-3">
                                        <span>Split {{ $i }}</span>
                                        <input type="number"  readonly
                                            wire:model.live="splits.{{ $i }}.amount"
                                            class="w-32 rounded-lg border-gray-300 text-right"
                                            placeholder="{{ number_format($order->total / $numberOfSplits, 2) }}">
                                    </div>
                                    <select class="rounded-lg border-gray-300 w-28"
                                        wire:model.live="splits.{{ $i }}.paymentMethod">
                                        <option value="cash">{{ __('modules.order.cash') }}</option>
                                        <option value="card">{{ __('modules.order.card') }}</option>
                                        <option value="upi">{{ __('modules.order.upi') }}</option>
                                        <option value="due">{{ __('modules.order.due') }}</option>
                                    </select>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Custom Split Options -->
                    <div x-show="splitType === 'custom'" class="h-full flex flex-col">
                        <div class="flex items-center gap-2 border-b pb-4">
                            <div class="flex flex-wrap gap-2 flex-1">
                                @foreach($customSplits as $splitNumber)
                                    <div class="flex items-center gap-1">
                                        <div class="px-4 py-2 rounded-lg text-sm border">
                                            <span>Split {{ $splitNumber }}</span>
                                        </div>
                                        @if(count($customSplits) > 2)
                                            <button wire:click="removeCustomSplit({{ $splitNumber }})"
                                                class="p-1 text-gray-400 hover:text-red-500 rounded-full hover:bg-gray-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button wire:click="addNewCustomSplit"
                                class="px-3 py-2 text-sm border rounded-lg hover:bg-gray-50 shrink-0">
                                + New Split
                            </button>
                        </div>
                        <div class="flex-1 grid grid-cols-2 gap-4 content-start">
                            @foreach($customSplits as $splitNumber)
                                <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                    <div class="flex-1 flex justify-between items-center gap-3">
                                        <span>Split {{ $splitNumber }}</span>
                                        <input type="number"
                                            wire:model.live="splits.{{ $splitNumber }}.amount"
                                            class="w-32 rounded-lg border-gray-300 text-right"
                                            placeholder="0.00">
                                    </div>
                                    <select class="rounded-lg border-gray-300 w-28"
                                        wire:model.live="splits.{{ $splitNumber }}.paymentMethod">
                                        <option value="cash">{{ __('modules.order.cash') }}</option>
                                        <option value="card">{{ __('modules.order.card') }}</option>
                                        <option value="upi">{{ __('modules.order.upi') }}</option>
                                        <option value="due">{{ __('modules.order.due') }}</option>
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Items Split Options -->
                    <div x-show="splitType === 'items'" class="space-y-6">
                        <!-- Splits Navigation -->
                        <div class="flex items-center gap-2 border-b pb-4">
                            <div class="flex flex-wrap gap-2 flex-1">
                                @foreach($splits as $splitId => $split)
                                    <div class="flex items-center gap-1">
                                        <button wire:click="$set('activeSplitId', {{ $splitId }})"
                                            class="px-4 py-2 rounded-lg text-sm font-medium
                                            {{ $activeSplitId === $splitId ? 'bg-skin-base text-white' : 'border hover:bg-gray-50' }}">
                                            <span>Split {{ $splitId }}</span>
                                        </button>
                                        @if(count($splits) > 1 && $splitId !== 1)
                                            <button wire:click="removeItemSplit({{ $splitId }})"
                                                class="p-1 text-gray-400 hover:text-red-500 rounded-full hover:bg-gray-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button wire:click="addNewItemSplit"
                                class="px-3 py-2 text-sm border rounded-lg hover:bg-gray-50 shrink-0">
                                + {{ __('modules.order.newSplit') }}
                            </button>
                        </div>

                        <!-- Split Content - Side by Side Layout -->
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Left Side - Available Items -->
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-medium text-sm text-gray-500">{{ __('modules.order.availableItems') }}</h4>
                                    <span class="text-sm text-gray-500">{{ __('modules.order.clickToAdd') }}</span>
                                </div>
                                <div class="space-y-2 max-h-[400px] overflow-y-auto">
                                    @foreach($availableItems as $index => $item)
                                        @if($item['remaining'] > 0)
                                        <div class="p-3 border rounded-lg hover:bg-gray-50 cursor-pointer"
                                            wire:click="addItemToSplit({{ $item['id'] }}, {{ $activeSplitId }})">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <span class="font-medium">{{ $item['name'] }}</span>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-sm font-medium">
                                                        {{ currency_format($item['price']) }}
                                                    </span>
                                                    <div class="text-xs text-gray-500">
                                                        <span>{{ __('modules.order.base') }}: {{ currency_format($item['base_price']) }}</span>
                                                        @if($item['tax_amount'] > 0)
                                                            <span>+ {{ __('modules.order.tax') }}: {{ currency_format($item['tax_amount']) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Right Side - Selected Items -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-4">
                                    <div class="flex-1 flex justify-between items-center">
                                        <h4 class="font-medium text-sm text-gray-500">{{ __('modules.order.itemsInSplit', ['split' => $activeSplitId]) }}</h4>
                                        <span class="text-sm font-medium">
                                            {{ __('modules.order.total') }}: {{ currency_format($splits[$activeSplitId]['total'] ?? 0) }}
                                        </span>
                                    </div>
                                    <select class="rounded-lg border-gray-300 w-28 text-sm"
                                        wire:change="updateSplitPaymentMethod({{ $activeSplitId }}, $event.target.value)"
                                        x-model="$wire.splits[{{ $activeSplitId }}].paymentMethod">
                                        <option value="cash">{{ __('modules.order.cash') }}</option>
                                        <option value="card">{{ __('modules.order.card') }}</option>
                                        <option value="upi">{{ __('modules.order.upi') }}</option>
                                        <option value="due">{{ __('modules.order.due') }}</option>
                                    </select>
                                </div>
                                <div class="space-y-2 max-h-[400px] overflow-y-auto">
                                    @if(empty($splits[$activeSplitId]['items']))
                                        <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                                            {{ __('modules.order.noItemsInSplit') }}
                                        </div>
                                    @else
                                        @foreach($splits[$activeSplitId]['items'] as $index => $item)
                                        <div class="p-3 border rounded-lg hover:bg-gray-50">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <span class="font-medium">{{ $item['name'] }}</span>
                                                </div>
                                                <div class="flex items-center gap-4">
                                                    <div class="text-right">
                                                        <span class="font-medium">
                                                            {{ currency_format($item['price'] * $item['quantity']) }}
                                                        </span>
                                                        <div class="text-xs text-gray-500">
                                                            <span>{{ __('modules.order.base') }}: {{ currency_format($item['base_price'] * $item['quantity']) }}</span>
                                                            @if($item['tax_amount'] > 0)
                                                                <span>+ {{ __('modules.order.tax') }}: {{ currency_format($item['tax_amount'] * $item['quantity']) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <button wire:click="removeItemFromSplit({{ $activeSplitId }}, {{ $index }})"
                                                        class="text-sm text-red-500 hover:text-red-700">
                                                        {{ __('modules.order.remove') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($order)
                <!-- Footer - Fixed -->
                <div class="p-4 border-t bg-white dark:bg-gray-800">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>{{ __('modules.order.totalBill') }}</span>
                                <span class="font-medium">{{ currency_format($order->total) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('modules.order.splitAmount') }}</span>
                                <span class="font-medium">{{ currency_format(collect($splits)->sum('total')) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @endif
    </x-slot>

    <x-slot name="footer">
        @if($order)
        <div class="flex justify-between items-center w-full gap-4">
            <x-button-cancel class="flex-1 px-6 py-3 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-lg" wire:click="$toggle('showAddPaymentModal')">
                {{ __('app.cancel') }}
            </x-button-cancel>
            <x-button wire:click="submitForm" class="flex-1 px-6 py-3 text-base font-medium bg-skin-base text-white rounded-lg hover:bg-skin-base-600">
                {{ __('modules.order.completePayment') }}
            </x-button>
            </div>
        @endif
    </x-slot>

</x-dialog-modal>
