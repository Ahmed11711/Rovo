<div>

    <section class="bg-white dark:bg-gray-900 hidden lg:block px-4">
        <div
            class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12 bg-skin-base/[.1] dark:bg-gray-800 rounded-lg">
            <h1
                class="text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-3xl dark:text-white">
                @lang('messages.frontHeroHeading')</h1>
        </div>
    </section>

    @if (!$showCart)

        <div class="flex flex-col my-4 px-4">


            <!-- Card Section -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

                <a @class([
                    'group flex items-center border shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600',
                    'bg-skin-base' => is_null($menuId),
                    'bg-white' => !is_null($menuId),
                ]) wire:key='menu-{{ 'all-' . microtime() }}'
                    wire:click='filterMenuItems(null)' href="javascript:;">
                    <div class="p-2 sm:p-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-gray-100 p-2 rounded-md hidden sm:block">

                                <svg class="flex-shrink-0 size-5 text-gray-800 dark:text-neutral-200" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.221 409.221"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    enable-background="new 0 0 409.221 409.221">
                                    <path
                                        d="m387.059,389.218h-14.329v-18.114h14.327c5.523,0 10-4.477 10-10 0-55.795-42.81-101.781-97.305-106.843v-17.29c0-5.523-4.477-10-10-10s-10,4.477-10,10v17.29c-54.496,5.062-97.305,51.048-97.305,106.843 0,5.523 4.477,10 10,10h14.327v18.114h-14.327c-5.523,0-10,4.477-10,10s4.477,10 10,10h24.13c0.131,0.003 0.262,0.003 0.393,0h145.564c0.065,0.001 0.131,0.002 0.196,0.002s0.131,0 0.196-0.002h24.133c5.523,0 10-4.477 10-10s-4.478-10-10-10zm-34.33,0h-125.957v-18.114h125.957v18.114zm-149.714-38.113c4.978-43.447 41.978-77.305 86.736-77.305s81.758,33.858 86.736,77.305h-173.472zm-71.385-253.799c-29.383,1.42109e-14-52.4,16.809-52.4,38.267 0,21.457 23.017,38.265 52.4,38.265 29.383,0 52.399-16.808 52.399-38.265 0-21.459-23.016-38.267-52.399-38.267zm0,56.531c-19.094,0-32.4-9.625-32.4-18.265 0-8.64 13.306-18.267 32.4-18.267 19.093,0 32.399,9.627 32.399,18.267 0,8.639-13.306,18.265-32.399,18.265zm23.553,235.383h-123.021v-320.568h198.936v166.52c0,5.523 4.477,10 10,10s10-4.477 10-10v-176.52c0-5.523-4.477-10-10-10h-4.701v-38.652c0-2.858-1.223-5.58-3.36-7.478-2.137-1.897-4.984-2.789-7.822-2.452l-204.236,24.327c-5.03,0.599-8.817,4.864-8.817,9.93v364.893c0,5.523 4.477,10 10,10h133.021c5.523,0 10-4.477 10-10s-4.477-10-10-10zm-123.021-346.014l184.235-21.944v27.391h-184.235v-5.447zm82.627,317.362c-5.523,0-10-4.477-10-10s4.477-10 10-10h33.681c5.523,0 10,4.477 10,10s-4.477,10-10,10h-33.681z" />
                                </svg>

                            </div>

                            <div class="grow">
                                <h3 wire:loading.class.delay='opacity-50' @class([
                                    'font-semibold dark:group-hover:text-neutral-400 dark:text-neutral-200 text-xs lg:text-base',
                                    'text-gray-800 group-hover:text-skin-base' => !is_null($menuId),
                                    'text-white group-hover:text-white' => is_null($menuId),
                                ])>
                                    @lang('app.showAll')
                                </h3>

                            </div>
                        </div>
                    </div>
                </a>

                @forelse ($menuList as $item)
                    <!-- Card -->
                    <a @class([
                        'group flex flex-col border shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600',
                        'bg-skin-base' => $menuId == $item->id,
                        'bg-white' => $menuId != $item->id,
                    ]) wire:key='menu-{{ $item->id . microtime() }}'
                        wire:click='filterMenuItems({{ $item->id }})' href="javascript:;">
                        <div class="p-2 sm:p-3">
                            <div class="flex items-center gap-3">
                                <div class="bg-gray-100 p-2 rounded-md hidden sm:block">

                                    <svg class="flex-shrink-0 size-5 text-gray-800 dark:text-neutral-200" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.221 409.221"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        enable-background="new 0 0 409.221 409.221">
                                        <path
                                            d="m387.059,389.218h-14.329v-18.114h14.327c5.523,0 10-4.477 10-10 0-55.795-42.81-101.781-97.305-106.843v-17.29c0-5.523-4.477-10-10-10s-10,4.477-10,10v17.29c-54.496,5.062-97.305,51.048-97.305,106.843 0,5.523 4.477,10 10,10h14.327v18.114h-14.327c-5.523,0-10,4.477-10,10s4.477,10 10,10h24.13c0.131,0.003 0.262,0.003 0.393,0h145.564c0.065,0.001 0.131,0.002 0.196,0.002s0.131,0 0.196-0.002h24.133c5.523,0 10-4.477 10-10s-4.478-10-10-10zm-34.33,0h-125.957v-18.114h125.957v18.114zm-149.714-38.113c4.978-43.447 41.978-77.305 86.736-77.305s81.758,33.858 86.736,77.305h-173.472zm-71.385-253.799c-29.383,1.42109e-14-52.4,16.809-52.4,38.267 0,21.457 23.017,38.265 52.4,38.265 29.383,0 52.399-16.808 52.399-38.265 0-21.459-23.016-38.267-52.399-38.267zm0,56.531c-19.094,0-32.4-9.625-32.4-18.265 0-8.64 13.306-18.267 32.4-18.267 19.093,0 32.399,9.627 32.399,18.267 0,8.639-13.306,18.265-32.399,18.265zm23.553,235.383h-123.021v-320.568h198.936v166.52c0,5.523 4.477,10 10,10s10-4.477 10-10v-176.52c0-5.523-4.477-10-10-10h-4.701v-38.652c0-2.858-1.223-5.58-3.36-7.478-2.137-1.897-4.984-2.789-7.822-2.452l-204.236,24.327c-5.03,0.599-8.817,4.864-8.817,9.93v364.893c0,5.523 4.477,10 10,10h133.021c5.523,0 10-4.477 10-10s-4.477-10-10-10zm-123.021-346.014l184.235-21.944v27.391h-184.235v-5.447zm82.627,317.362c-5.523,0-10-4.477-10-10s4.477-10 10-10h33.681c5.523,0 10,4.477 10,10s-4.477,10-10,10h-33.681z" />
                                    </svg>

                                </div>

                                <div class="grow">
                                    <h3 wire:loading.class.delay='opacity-50' @class([
                                        'font-semibold dark:group-hover:text-neutral-400 dark:text-neutral-200 text-xs lg:text-base',
                                        'text-gray-800 group-hover:text-skin-base' => $menuId != $item->id,
                                        'text-white group-hover:text-white' => $menuId == $item->id,
                                    ])>
                                        {{ $item->menu_name }}
                                    </h3>
                                    <p @class([
                                        'text-sm dark:text-neutral-500 hidden sm:block',
                                        'text-gray-500' => $menuId != $item->id,
                                        'text-gray-100' => $menuId == $item->id,
                                    ])>
                                        {{ $item->items_count }} @lang('modules.menu.item')
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @empty
                    <div class="inline-flex items-center dark:text-gray-400">
                        @lang('messages.noMenuAdded')
                    </div>
                @endforelse

            </div>
            <!-- End Card Section -->
        </div>

        <div
            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 justify-center mt-6 px-4 hidden lg:flex mx-4">
            <ul class="flex flex-wrap -mb-px">

                <li class="me-2">
                    <a href="javascript:;" wire:click="filterMenu(null)" @class([
                        'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                        'text-skin-base border-skin-base active dark:text-skin-base dark:border-skin-base' => is_null(
                            $filterCategories),
                        'border-transparent' => !is_null($filterCategories),
                    ])
                        aria-current="page">
                        @lang('app.showAll')
                    </a>
                </li>

                @foreach ($categoryList as $key => $item)
                    <li class="me-2">
                        <a href="javascript:;" wire:click="filterMenu({{ $item->id }})"
                            @class([
                                'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                                'text-skin-base border-skin-base active dark:text-skin-base dark:border-skin-base' =>
                                    $filterCategories == $item->id,
                                'border-transparent' => $filterCategories != $item->id,
                            ])>
                            {{ $item->category_name }} ({{ $item->items->count() }})
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>


        <div class="grid grid-cols-3 my-4 lg:my-12 px-4">
            <div class="col-span-2">
                <x-input id="menu_name" class="block mt-1 w-full" type="text"
                    placeholder="{{ __('placeholders.searchMenuItems') }}" wire:model.live.debounce.500ms="search" />
            </div>
            <div class="flex items-center justify-end">
                <label class="inline-flex items-center cursor-pointer" id="veg_toggle">
                    <input type="checkbox" value="1" wire:model.live='showVeg' class="sr-only peer">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('modules.menu.typeVeg')</span>
                </label>
            </div>
        </div>
    @endif


    @if ($showMenu)
        <div class="space-y-4 mb-32 lg:gap-8 px-4">
            @forelse ($menuItems as $key => $itemCat)
                <h3 class="lg:text-xl text-base font-semibold text-gray-900 dark:text-white my-4">{{ $key }}</h3>
                <div class="space-y-4 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-8">
                    @foreach ($itemCat as $item)
                    <div class="flex items-center justify-between gap-6 border shadow-sm rounded-lg hover:shadow-md transition dark:border-gray-600 dark:lg:bg-gray-900 dark:shadow-sm lg:bg-white lg:rounded-md"
                        wire:key='menu-item-{{ $item->id . microtime() }}'>
                        <div class="flex space-x-4 w-full p-3">
                            <img class="w-16 h-16 lg:w-24 lg:h-24 rounded-md object-cover cursor-pointer" wire:click="showItemDetail({{ $item->id }})"
                                src="{{ $item->item_photo_url }}" alt="{{ $item->item_name }}">
                            <div
                                class="text-sm lg:text-base font-normal text-gray-500 dark:text-gray-400 flex flex-col gap-1 w-full">
                                <div
                                    class="text-sm lg:text-base font-semibold text-gray-900 dark:text-white inline-flex items-center">
                                    <img src="{{ asset('img/' . $item->type . '.svg') }}" class="h-4 mr-1"
                                        title="@lang('modules.menu.' . $item->type)" alt="" />
                                    {{ $item->item_name }}
                                </div>
                                @if ($item->description)
                                    <div class="text-xs lg:text-sm font-normal text-gray-500 dark:text-gray-400 w-full cursor-pointer" wire:click="showItemDetail({{ $item->id }})">
                                        {{ str($item->description)->limit(50) }}</div>
                                @endif

                                @if ($item->preparation_time)
                                    <div
                                        class="text-xs font-normal text-gray-700 dark:text-gray-400 max-w-56 items-center inline-flex my-1">
                                        @lang('modules.menu.preparationTime') :
                                        {{ $item->preparation_time }} @lang('modules.menu.minutes')</div>
                                @endif
                                <div class="flex justify-between w-full items-center">
                                    <div>
                                        @if ($item->variations_count == 0)
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ currency_format($item->price,
                                            $restaurant->currency_id) }}</span>
                                        @else
                                        <span class="text-xs text-gray-900 dark:text-white">({{ $item->variations_count }})
                                            @lang('modules.menu.itemVariations')</span>
                                        @endif
                                    </div>

                                    @if ($canCreateOrder)
                                        @if ($restaurant->allow_customer_orders)
                                            @if (isset($cartItemQty[$item->id]) && $cartItemQty[$item->id] > 0)
                                            <div class="relative flex items-center max-w-24 justify-start me-2" wire:key='orderItemQty-{{ $item->id }}-counter'>
                                                <button type="button"
                                                    @if ($item->variations_count > 0)
                                                        wire:click="subCartItems({{ $item->id }})"
                                                    @elseif($item->modifier_groups_count > 0)
                                                        wire:click="subModifiers({{ $item->id }})"
                                                    @else
                                                        wire:click="subQty('{{ $item->id }}')"
                                                    @endif
                                                    class="bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border
                                                    border-gray-300 rounded-s-md p-3 h-8">
                                                    <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 18 2">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                    </svg>
                                                </button>

                                                <input type="text" wire:model='cartItemQty.{{ $item->id }}'
                                                    class="min-w-10 bg-white border-x-0 border-gray-300 h-8 text-center text-gray-900 text-sm  block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white "
                                                    value="1" readonly />
                                                <button type="button"
                                                    wire:click="
                                                        @if ($item->variations_count > 0 || $item->modifier_groups_count > 0)
                                                            addCartItems({{ $item->id }}, {{ $item->variations_count }}, {{ $item->modifier_groups_count }})
                                                        @else
                                                            addQty('{{ $item->id }}')
                                                        @endif
                                                    "
                                                    class="bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border
                                                    border-gray-300 rounded-e-md p-3 h-8 ">
                                                    <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 18 18">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 1v16M1 9h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            @else
                                            <x-cart-button wire:click='addCartItems({{ $item->id }}, {{ $item->variations_count }} , {{ $item->modifier_groups_count }})'
                                                wire:key='item-input-{{ $item->id . microtime() }}'>@lang('app.add')</x-cart-button>
                                            @endif
                                        @endif
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            @empty
                @lang('messages.noItemAdded')
            @endforelse

            <div class="w-full max-w-lg flex justify-center gap-6 bottom-24 fixed -ml-4 lg:hidden">
                <x-button class="inline-flex items-center gap-2" wire:click="$toggle('showMenuModal')">
                    <svg class="w-4 h-4 transition duration-75 group-hover:text-gray-900 dark:text-white dark:group-hover:text-white"
                        fill="currentColor" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.005 512.005"
                        xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <rect y="389.705" width="512.005" height="66.607"></rect>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path
                                        d="M297.643,131.433c4.862-7.641,7.693-16.696,7.693-26.404c0-27.204-22.132-49.336-49.336-49.336 c-27.204,0-49.336,22.132-49.336,49.337c0,9.708,2.831,18.763,7.693,26.404C102.739,149.772,15.208,240.563,1.801,353.747h508.398 C496.792,240.563,409.261,149.772,297.643,131.433z M256,118.415c-7.38,0-13.384-6.005-13.384-13.385S248.62,91.646,256,91.646 s13.384,6.004,13.384,13.384S263.38,118.415,256,118.415z">
                                    </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                    @lang('app.menu')
                </x-button>

                @if ($restaurant->is_waiter_request_enabled && $restaurant->is_waiter_request_enabled_on_mobile && $this->shouldShowWaiterButton )
                    @livewire('forms.callWaiterButton', ['tableNumber' => $table->id ?? null, 'shopBranch' => $shopBranch])
                @endif
            </div>

            @if ($cartQty > 0)
                <div
                    class="bg-skin-base text-white rounded-md w-full max-w-lg lg:max-w-screen-xl flex items-center justify-between p-4 dark:bg-gray-800 antialiased bottom-1 fixed z-10 mx-auto font-bold -ml-4">
                    <div>@lang('modules.order.totalItem'): {{ $cartQty }} &nbsp;|&nbsp;
                        {{ currency_format($subTotal, $restaurant->currency_id) }} + @lang('modules.order.taxes')</div>

                    <x-secondary-button wire:click="showCartItems">@lang('modules.order.viewCart')</x-secondary-button>

                </div>
            @endif
        </div>
    @endif

    @if ($showCart)

        @if ($restaurant->allow_customer_orders)
            <div class="flex my-4">

                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg flex  divide-x mx-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @if ($restaurant->allow_dine_in_orders)
                    <li class="w-full border-b border-gray-200 sm:border-b-0 dark:border-gray-600 cursor-pointer">
                        <div class="flex items-center ps-3">
                            <input id="horizontal-list-radio-dine_in" wire:model.live='orderType' type="radio"
                                value="dine_in" name="list-radio"
                                class="w-4 h-4 text-skin-base bg-gray-100 border-gray-300 focus:ring-skin-base dark:focus:ring-skin-base dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="horizontal-list-radio-dine_in"
                                class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('modules.order.dine_in')</label>
                        </div>
                    </li>
                    @endif
                    @if ($restaurant->allow_customer_delivery_orders)
                        <li class="w-full border-b border-gray-200 sm:border-b-0  dark:border-gray-600 cursor-pointer">
                            <div class="flex items-center ps-3 ">
                                <input id="horizontal-list-radio-delivery" wire:model.live='orderType' type="radio"
                                    value="delivery" name="list-radio"
                                    class="w-4 h-4 text-skin-base bg-gray-100 border-gray-300 focus:ring-skin-base dark:focus:ring-skin-base dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="horizontal-list-radio-delivery"
                                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('modules.order.delivery')</label>
                            </div>
                        </li>
                    @endif

                    @if ($restaurant->allow_customer_pickup_orders)
                        <li class="w-full border-b border-gray-200 sm:border-b-0  dark:border-gray-600">
                            <div class="flex items-center ps-3 ">
                                <input id="horizontal-list-radio-pickup" wire:model.live='orderType' type="radio"
                                    value="pickup" name="list-radio"
                                    class="w-4 h-4 text-skin-base bg-gray-100 border-gray-300 focus:ring-skin-base dark:focus:ring-skin-base dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="horizontal-list-radio-pickup"
                                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('modules.order.pickup')</label>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
        <div class="space-y-4 px-4 mt-4">
            @foreach ($orderItemList as $key => $item)
                <div class="grid grid-cols-3 items-center gap-4" wire:key='menu-item-{{ $item->id . microtime() }}'>
                    <div class="flex flex-col">
                        <div class="text-md text-gray-900 dark:text-white inline-flex items-center">
                            {{ $item->item_name }}
                        </div>
                        <div class="text-xs text-gray-600 dark:text-white inline-flex items-center mb-1">
                            {{ isset($orderItemVariation[$key]) ? $orderItemVariation[$key]->variation : '' }}
                        </div>
                        @if (!empty($itemModifiersSelected[$key]))
                        <div class="text-xs text-gray-600 dark:text-white w-full md:w-1/2">
                            @foreach ($itemModifiersSelected[$key] as $modifierOptionId)
                            <div class="flex items-center justify-between text-xs mb-1 py-0.5 px-1 border-l-2 border-blue-500 bg-gray-200 dark:bg-gray-900 rounded-md">
                                <span class="text-gray-900 dark:text-white">{{ $this->modifierOptions[$modifierOptionId]->name }}</span>
                                <span class="text-gray-600 dark:text-gray-300">{{
                                    currency_format($this->modifierOptions[$modifierOptionId]->price, $this->modifierOptions[$modifierOptionId]->modifierGroup->branch->restaurant->currency_id) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="flex justify-end">

                        <div class="relative flex items-center max-w-[8rem] mx-auto"
                            wire:key='orderItemQty-{{ $key }}-counter'>
                            <button type="button" wire:click="subQty('{{ $key }}')"
                                class="bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-md p-3 h-8">
                                <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>

                            <input type="text" wire:model='orderItemQty.{{ $key }}'
                                class="min-w-10 bg-white border-x-0 border-gray-300 h-8 text-center text-gray-900 text-sm  block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white "
                                value="1" readonly />

                            <button type="button" wire:click="addQty('{{ $key }}')"
                                class="bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-md p-3 h-8 ">
                                <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>

                    </div>
                    <div class="flex justify-end">
                        @php
                            $itemPrice = isset($orderItemVariation[$key]) ? $orderItemVariation[$key]->price : $item->price;
                            $itemPrice += isset($orderItemModifiersPrice[$key]) ? $orderItemModifiersPrice[$key] : 0;
                        @endphp
                        {{ currency_format($orderItemQty[$key] * $itemPrice, $restaurant->currency_id) }}
                    </div>
                </div>
            @endforeach

            @if ($cartQty > 0)
                <div>
                    <div
                        class="h-auto p-4 mt-3 select-none text-center w-full bg-gray-50 rounded space-y-4 dark:bg-gray-700">
                        <div class="flex justify-between text-gray-500 dark:text-gray-400 text-sm">
                            <div>
                                @lang('modules.order.totalItem')
                            </div>
                            <div>
                                {{ count($orderItemList) }}
                            </div>
                        </div>
                        <div class="flex justify-between text-gray-500 dark:text-gray-400 text-sm">
                            <div>
                                @lang('modules.order.subTotal')
                            </div>
                            <div>
                                {{ currency_format($subTotal, $restaurant->currency_id) }}
                            </div>
                        </div>
                        @foreach ($taxes as $item)
                            <div class="flex justify-between text-gray-500 dark:text-gray-400 text-sm">
                                <div>
                                    {{ $item->tax_name }} ({{ $item->tax_percent }}%)
                                </div>
                                <div>
                                    {{ currency_format(($item->tax_percent / 100) * $subTotal, $restaurant->currency_id) }}
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-between font-medium text-gray-900 dark:text-white">
                            <div>
                                @lang('modules.order.total')
                            </div>
                            <div>
                                {{ currency_format($total, $restaurant->currency_id) }}
                            </div>
                        </div>
                    </div>

                    <div class="h-auto pb-4 pt-3 select-none text-center w-full"
                        wire:key='order-{{ microtime() }}'>
                        <div class="flex gap-2">
                            @if (is_null($customer) && ($restaurant->customer_login_required || $orderType == 'delivery'))
                                <x-button class="w-full justify-center"
                                    wire:click="$dispatch('showSignup')">@lang('app.next')</x-button>
                            @else
                                <div class="grid grid-cols-2 gap-2 w-full">
                                    @php
                                        $isPaymentEnabled =
                                            in_array($orderType, ['dine_in', 'delivery', 'pickup']) &&
                                            (($orderType == 'dine_in' && $paymentGateway->is_dine_in_payment_enabled) ||
                                                ($orderType == 'delivery' &&
                                                    $paymentGateway->is_delivery_payment_enabled) ||
                                                ($orderType == 'pickup' && $paymentGateway->is_pickup_payment_enabled));
                                    @endphp

                                    @if (
                                        $paymentGateway->is_qr_payment_enabled ||
                                            $paymentGateway->stripe_status ||
                                            $paymentGateway->razorpay_status ||
                                            $paymentGateway->is_offline_payment_enabled)

                                            @if (!$order)
                                                <x-button class="w-full justify-center" wire:click="placeOrder(true)" wire:loading.attr="disabled">@lang('modules.order.payNow')</x-button>
                                            @endif

                                        @if ($paymentGateway->is_cash_payment_enabled)
                                            <x-secondary-button class="w-full justify-center"
                                                wire:click="placeOrder" wire:loading.attr="disabled" >@lang('modules.order.payLater')</x-secondary-button>
                                            {{-- <x-secondary-button class="w-full justify-center" wire:click="placeOrder">@lang('modules.order.payViaQr')</x-secondary-button> --}}
                                        @endif
                                    @else
                                        <x-button class="w-full justify-center"
                                            wire:click="placeOrder" wire:loading.attr="disabled" >@lang('modules.order.placeOrder')</x-button>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="flex mt-4"><a href="javascript:;"wire:click="showMenuItems"
                                class="text-sm text-gray-500 underline underline-offset-1">@lang('app.back')</a></div>
                    </div>

                </div>
            @else
                <div class="p-4 text-center md:py-7 md:px-5">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        @lang('messages.cartEmpty')
                    </h3>

                    <a class="mt-3 py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-skin-base text-white hover:bg-skin-base focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                        href="{{ module_enabled('Subdomain') ? url('/') : route('shop_restaurant', [$restaurant->hash]) }}"
                        wire:navigate>
                        @lang('modules.order.placeOrder')
                    </a>
                </div>
            @endif
        </div>
    @endif

    <x-dialog-modal wire:model.live="showCustomerNameModal" maxWidth="sm">
        <x-slot name="title">

        </x-slot>

        <x-slot name="content">
            @if (!is_null($customer))
                <form wire:submit="submitCustomerName">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <x-label for="customerName" value="{{ __('modules.customer.enterName') }}" />
                            <x-input id="customerName" class="block mt-1 w-full" type="text"
                                wire:model='customerName' />
                            <x-input-error for="customerName" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="customerPhone " value="{{ __('modules.customer.phone') }}" />
                            <x-input id="customerPhone" class="block mt-1 w-full" type="text"
                                wire:model='customerPhone' />
                            <x-input-error for="customerPhone" class="mt-2" />
                        </div>

                        @if ($orderType == 'delivery')
                            <div>
                                <x-label for="customerAddress" value="{{ __('modules.customer.address') }}" />
                                <x-textarea id="customerAddress" class="block mt-1 w-full"
                                    wire:model='customerAddress' rows="2" />
                                <x-input-error for="customerAddress" class="mt-2" />
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-between w-full pb-4 space-x-4 mt-6">
                        <x-button>@lang('app.continue')</x-button>
                        <x-button-cancel wire:click="$toggle('showCustomerNameModal')"
                            wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
                    </div>
                </form>
            @endif
        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model.live="showTableModal" maxWidth="2xl">
        <x-slot name="title">
            @lang('modules.table.selectTable')
        </x-slot>

        <x-slot name="content">
            @if ($showTableModal && $getTable)
                <!-- Card Section -->
                <div class="space-y-8 col-span-2">
                    @forelse ($tables as $area)
                        <div class="flex flex-col gap-3 sm:gap-4 space-y-3"
                            wire:key='area-table-{{ $loop->index }}'>
                            <h3 class="f-15 font-medium inline-flex gap-2 items-center dark:text-neutral-200">
                                {{ $area->area_name }}
                                <span
                                    class="px-2 py-1 text-sm rounded bg-slate-100 border-gray-300 border text-gray-800 ">{{ $area->tables->count() }}
                                    @lang('modules.table.table')</span>
                            </h3>
                            <!-- Card -->

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                                @foreach ($area->tables as $item)
                                    <a @class([
                                        'group cursor-pointer flex items-center justify-center border shadow-sm rounded-lg hover:shadow-md
                                                                                                                                                                                                                                                                                                                                                                                                    transition dark:bg-gray-700 dark:border-gray-600',
                                        'bg-red-50' => $item->status == 'inactive',
                                        'bg-white' => $item->status == 'active',
                                    ]) wire:key='table-{{ $loop->index }}'
                                        wire:click="selectTableOrder('{{ $item->hash }}')">
                                        <div class="p-3">
                                            <div class="flex flex-col space-y-2 items-center justify-center">
                                                @if ($item->status == 'inactive')
                                                    <div class="inline-flex text-xs gap-1 text-red-600 font-semibold">
                                                        @lang('app.inactive')
                                                    </div>
                                                @endif
                                                <div @class([
                                                    'p-2 rounded-lg tracking-wide ',
                                                    ' bg-green-100 text-green-600' => $item->available_status == 'available',
                                                    'bg-red-100 text-red-600' => $item->available_status == 'reserved',
                                                    'bg-blue-100 text-blue-600' => $item->available_status == 'running',
                                                ])>
                                                    <h3 wire:loading.class.delay='opacity-50'
                                                        @class(['font-semibold'])>
                                                        {{ $item->table_code }}
                                                    </h3>
                                                </div>
                                                <p @class(['text-xs font-medium dark:text-neutral-200 text-gray-500'])>
                                                    {{ $item->seating_capacity }} @lang('modules.table.seats')
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- End Card -->
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div>
                            @lang('messages.noTablesFound')
                        </div>
                    @endforelse

                </div>
                <!-- End Card Section -->
            @endif
        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model.live="showVariationModal" maxWidth="xl">
        <x-slot name="title">
            @lang('modules.menu.itemVariations')
        </x-slot>

        <x-slot name="content">
            @if ($menuItem)
                @livewire('pos.itemVariations', ['menuItem' => $menuItem], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-button-cancel wire:click="$toggle('showVariationModal')" wire:loading.attr="disabled" />
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="showCartVariationModal" maxWidth="sm">
        <x-slot name="title">
            @lang('modules.menu.itemVariations')
        </x-slot>

        <x-slot name="content">
            @if ($menuItem)
                @livewire('shop.cartItemVariations', ['menuItem' => $menuItem, 'orderItemQty' => $orderItemQty], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-button-cancel wire:click="$toggle('showCartVariationModal')" wire:loading.attr="disabled" />
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="showItemDetailModal" maxWidth="sm">
        <x-slot name="title">
            @lang('modules.menu.itemDescription')
        </x-slot>

        <x-slot name="content">
            @if ($selectedItem)
                <div class="flex flex-col gap-2">
                    <div class="flex flex-col gap-2">
                        <img src="{{ $selectedItem->item_photo_url }}" alt="{{ $selectedItem->item_name }}" class="w-full rounded-md object-cover">
                        <div class="flex flex-col gap-1">
                            <h3 class="text-lg font-semibold dark:text-white">{{ $selectedItem->item_name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">{{ $selectedItem->description }}</p>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    @lang('modules.menu.preparationTime')
                                    {{ $selectedItem->preparation_time }} @lang('modules.menu.minutes')
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-button-cancel wire:click="$toggle('showItemDetailModal')" wire:loading.attr="disabled" />
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="showMenuModal" maxWidth="sm">
        <x-slot name="title">
            @lang('app.menu')
        </x-slot>

        <x-slot name="content">
            <div class="justify-between items-center w-full bg-gray-50 mt-4 rounded-md dark:bg-gray-800">
                <ul class="flex flex-col font-medium ">
                    <li wire:key='item-cat-{{ 'all' . microtime() }}'>
                        <a href="javascript:;" wire:click="filterMenu(null)"
                            class="block py-2 pr-4 pl-3 text-gray-700 rounded bg-primary-700   dark:text-white"
                            aria-current="page">@lang('app.showAll')</a>
                    </li>

                    @foreach ($categoryList as $key => $item)
                        <li wire:key='item-cat-{{ $item->id . microtime() }}'>
                            <a href="javascript:;" wire:click="filterMenu({{ $item->id }})"
                                class="block py-2 pr-4 pl-3 text-gray-700 rounded  dark:text-white"
                                aria-current="page">{{ $item->category_name }} ({{ $item->items->count() }})</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button-cancel wire:click="$toggle('showMenuModal')" wire:loading.attr="disabled" />
        </x-slot>
    </x-dialog-modal>

    @if ($paymentOrder)
        <x-dialog-modal wire:model.live="showPaymentModal" maxWidth="md">
            <x-slot name="title">
                @lang('modules.order.chooseGateway')
            </x-slot>

            <x-slot name="content">
                <div class="flex items-center justify-between cursor-pointer mb-6  bg-gray-50 dark:bg-gray-800 rounded-md p-2">
                    <div class="flex items-center min-w-0">
                        <div>
                            <div class="font-medium text-gray-700 truncate dark:text-white">
                                @lang('modules.order.orderNumber') #{{ $paymentOrder->order_number }}
                            </div>
                        </div>
                    </div>
                    <div class="inline-flex flex-col text-right text-base font-semibold text-gray-900 dark:text-white">
                        <div>{{ currency_format($paymentOrder->total, $restaurant->currency_id) }}</div>
                    </div>
                </div>

                @if ($showQrCode || $showPaymentDetail)
                    <x-secondary-button wire:click="{{ $showQrCode ? 'toggleQrCode' : 'togglePaymenntDetail' }}">
                        <span class="ml-2">@lang('modules.billing.showOtherPaymentOption')</span>
                    </x-secondary-button>

                    <div class="mt-2 flex items-center">
                        @if ($showQrCode)
                            <img src="{{ $paymentGateway->qr_code_image_url }}" alt="QR Code Preview"
                                class="rounded-md h-30 w-30 object-cover">
                        @else
                            <span class="text-gray-700 font-bold p-3 rounded">@lang('modules.billing.accountDetails')</span>
                            <span>{{ $paymentGateway->offline_payment_detail }}</span>
                        @endif
                    </div>
                @else
                    <div class="grid items-center grid-cols-1 md:grid-cols-2 w-full mt-4 gap-6">
                        @if ($paymentGateway->stripe_status)

                                <x-secondary-button wire:click='initiateStripePayment({{ $paymentOrder->id }})'>
                                    <span class="inline-flex items-center">
                                        <svg version="1.1" height="21" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 468 222.5" style="enable-background:new 0 0 468 222.5;"
                                            xml:space="preserve">
                                            <style type="text/css">
                                                .ststr0 {
                                                    fill-rule: evenodd;
                                                    clip-rule: evenodd;
                                                    fill: #635BFF;
                                                }
                                            </style>
                                            <g>
                                                <path class="ststr0" d="M414,113.4c0-25.6-12.4-45.8-36.1-45.8c-23.8,0-38.2,20.2-38.2,45.6c0,30.1,17,45.3,41.4,45.3
                            c11.9,0,20.9-2.7,27.7-6.5v-20c-6.8,3.4-14.6,5.5-24.5,5.5c-9.7,0-18.3-3.4-19.4-15.2h48.9C413.8,121,414,115.8,414,113.4z
                            M364.6,103.9c0-11.3,6.9-16,13.2-16c6.1,0,12.6,4.7,12.6,16H364.6z" />
                                                <path class="ststr0"
                                                    d="M301.1,67.6c-9.8,0-16.1,4.6-19.6,7.8l-1.3-6.2h-22v116.6l25-5.3l0.1-28.3c3.6,2.6,8.9,6.3,17.7,6.3
                            c17.9,0,34.2-14.4,34.2-46.1C335.1,83.4,318.6,67.6,301.1,67.6z M295.1,136.5c-5.9,0-9.4-2.1-11.8-4.7l-0.1-37.1
                            c2.6-2.9,6.2-4.9,11.9-4.9c9.1,0,15.4,10.2,15.4,23.3C310.5,126.5,304.3,136.5,295.1,136.5z" />
                                                <polygon class="ststr0"
                                                    points="223.8,61.7 248.9,56.3 248.9,36 223.8,41.3 	" />
                                                <rect x="223.8" y="69.3" class="ststr0" width="25.1"
                                                    height="87.5" />
                                                <path class="ststr0"
                                                    d="M196.9,76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7,15.9-6.3,19-5.2v-23C214.5,68.1,202.8,65.9,196.9,76.7z" />
                                                <path class="ststr0" d="M146.9,47.6l-24.4,5.2l-0.1,80.1c0,14.8,11.1,25.7,25.9,25.7c8.2,0,14.2-1.5,17.5-3.3V135
                            c-3.2,1.3-19,5.9-19-8.9V90.6h19V69.3h-19L146.9,47.6z" />
                                                <path class="ststr0" d="M79.3,94.7c0-3.9,3.2-5.4,8.5-5.4c7.6,0,17.2,2.3,24.8,6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6
                            C67.5,67.6,54,78.2,54,95.9c0,27.6,38,23.2,38,35.1c0,4.6-4,6.1-9.6,6.1c-8.3,0-18.9-3.4-27.3-8v23.8c9.3,4,18.7,5.7,27.3,5.7
                            c20.8,0,35.1-10.3,35.1-28.2C117.4,100.6,79.3,105.9,79.3,94.7z" />
                                            </g>
                                        </svg>
                                    </span>
                                </x-secondary-button>
                            @endif

                            @if ($paymentGateway->razorpay_status)
                                <x-secondary-button wire:click='initiatePayment({{ $paymentOrder->id }})'>
                                    <span class="inline-flex items-center">
                                        <svg height="21" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 122.88 26.53" style="enable-background:new 0 0 122.88 26.53"
                                            xml:space="preserve">
                                            <style type="text/css">
                                                <![CDATA[
                                                .strp0 {
                                                    fill: #3395FF;
                                                }

                                                .st1 {
                                                    fill: #072654;
                                                }
                                                ]]>
                                            </style>
                                            <g>
                                                <polygon class="st1"
                                                    points="11.19,9.03 7.94,21.47 0,21.47 1.61,15.35 11.19,9.03" />
                                                <path class="st1"
                                                    d="M28.09,5.08C29.95,5.09,31.26,5.5,32,6.33s0.92,2.01,0.51,3.56c-0.27,1.06-0.82,2.03-1.59,2.8 c-0.8,0.8-1.78,1.38-2.87,1.68c0.83,0.19,1.34,0.78,1.5,1.79l0.03,0.22l0.6,5.09h-3.7l-0.62-5.48c-0.01-0.18-0.06-0.36-0.15-0.52 c-0.09-0.16-0.22-0.29-0.37-0.39c-0.31-0.16-0.65-0.24-1-0.25h-0.21h-2.28l-1.74,6.63h-3.46l4.3-16.38H28.09L28.09,5.08z M122.88,9.37l-4.4,6.34l-5.19,7.52l-0.04,0.04l-1.16,1.68l-0.04,0.06L112,25.09l-1,1.44h-3.44l4.02-5.67l-1.82-11.09h3.57 l0.9,7.23l4.36-6.19l0.06-0.09l0.07-0.1l0.07-0.09l0.54-1.15H122.88L122.88,9.37z M92.4,10.25c0.66,0.56,1.09,1.33,1.24,2.19 c0.18,1.07,0.1,2.18-0.21,3.22c-0.29,1.15-0.78,2.23-1.46,3.19c-0.62,0.88-1.42,1.61-2.35,2.13c-0.88,0.48-1.85,0.73-2.85,0.73 c-0.71,0.03-1.41-0.15-2.02-0.51c-0.47-0.28-0.83-0.71-1.03-1.22l-0.06-0.2l-1.77,6.75h-3.43l3.51-13.4l0.02-0.06l0.01-0.06 l0.86-3.25h3.35l-0.57,1.88l-0.01,0.08c0.49-0.7,1.15-1.27,1.91-1.64c0.76-0.4,1.6-0.6,2.45-0.6C90.84,9.43,91.7,9.71,92.4,10.25 L92.4,10.25z M88.26,12.11c-0.4-0.01-0.8,0.07-1.18,0.22c-0.37,0.15-0.71,0.38-1,0.66c-0.68,0.7-1.15,1.59-1.36,2.54 c-0.3,1.11-0.28,1.95,0.02,2.53c0.3,0.58,0.87,0.88,1.72,0.88c0.81,0.02,1.59-0.29,2.18-0.86c0.66-0.69,1.12-1.55,1.33-2.49 c0.29-1.09,0.27-1.96-0.03-2.57S89.08,12.11,88.26,12.11L88.26,12.11z M103.66,9.99c0.46,0.29,0.82,0.72,1.02,1.23l0.07,0.19 l0.44-1.66h3.36l-3.08,11.7h-3.37l0.45-1.73c-0.51,0.61-1.15,1.09-1.87,1.42c-0.7,0.32-1.45,0.49-2.21,0.49 c-0.88,0.04-1.76-0.21-2.48-0.74c-0.66-0.52-1.1-1.28-1.24-2.11c-0.18-1.06-0.12-2.14,0.19-3.17c0.3-1.15,0.8-2.24,1.49-3.21 c0.63-0.89,1.44-1.64,2.38-2.18c0.86-0.5,1.84-0.77,2.83-0.77C102.36,9.43,103.06,9.61,103.66,9.99L103.66,9.99z M101.92,12.14 c-0.41,0-0.82,0.08-1.19,0.24c-0.38,0.16-0.72,0.39-1.01,0.68c-0.67,0.71-1.15,1.59-1.36,2.55c-0.28,1.08-0.28,1.9,0.04,2.49 c0.31,0.59,0.89,0.87,1.75,0.87c0.4,0.01,0.8-0.07,1.18-0.22s0.71-0.38,1-0.66c0.59-0.63,1.02-1.38,1.26-2.22l0.08-0.31 c0.3-1.11,0.29-1.96-0.03-2.53C103.33,12.44,102.76,12.14,101.92,12.14L101.92,12.14z M81.13,9.63l0.22,0.09l-0.86,3.19 c-0.49-0.26-1.03-0.39-1.57-0.39c-0.82-0.03-1.62,0.24-2.27,0.75c-0.56,0.48-0.97,1.12-1.18,1.82l-0.07,0.27l-1.6,6.11h-3.42 l3.1-11.7h3.37l-0.44,1.72c0.42-0.58,0.96-1.05,1.57-1.4c0.68-0.39,1.44-0.59,2.22-0.59C80.51,9.48,80.83,9.52,81.13,9.63 L81.13,9.63z M68.5,10.19c0.76,0.48,1.31,1.24,1.52,2.12c0.25,1.06,0.21,2.18-0.11,3.22c-0.3,1.18-0.83,2.28-1.58,3.22 c-0.71,0.91-1.61,1.63-2.64,2.12c-1.05,0.49-2.19,0.74-3.35,0.73c-1.22,0-2.22-0.24-3-0.73c-0.77-0.48-1.32-1.24-1.54-2.12 c-0.24-1.06-0.2-2.18,0.11-3.22c0.3-1.17,0.83-2.27,1.58-3.22c0.71-0.9,1.62-1.63,2.66-2.12c1.06-0.49,2.22-0.75,3.39-0.73 C66.57,9.41,67.6,9.67,68.5,10.19L68.5,10.19z M64.84,12.1c-0.81-0.01-1.59,0.3-2.18,0.86c-0.61,0.58-1.07,1.43-1.36,2.57 c-0.6,2.29-0.02,3.43,1.74,3.43c0.8,0.02,1.57-0.29,2.15-0.85c0.6-0.57,1.04-1.43,1.34-2.58c0.3-1.13,0.31-1.98,0.01-2.57 C66.25,12.37,65.68,12.1,64.84,12.1L64.84,12.1z M57.89,9.76l-0.6,2.32l-7.55,6.67h6.06l-0.72,2.73H45.05l0.63-2.41l7.43-6.57 h-5.65l0.72-2.73H57.89L57.89,9.76z M40.96,9.99c0.46,0.29,0.82,0.72,1.02,1.23l0.07,0.19l0.44-1.66h3.37l-3.07,11.7h-3.37 l0.45-1.73c-0.51,0.6-1.14,1.08-1.85,1.41s-1.48,0.5-2.27,0.5c-0.88,0.04-1.74-0.22-2.45-0.74c-0.66-0.52-1.1-1.28-1.24-2.11 c-0.18-1.06-0.12-2.14,0.19-3.17c0.29-1.15,0.8-2.24,1.49-3.21c0.63-0.89,1.44-1.64,2.37-2.18c0.86-0.5,1.84-0.76,2.83-0.76 C39.66,9.44,40.36,9.62,40.96,9.99L40.96,9.99z M39.23,12.14c-0.41,0-0.81,0.08-1.19,0.24c-0.38,0.16-0.72,0.39-1.01,0.68 c-0.68,0.71-1.15,1.59-1.36,2.55c-0.28,1.08-0.27,1.9,0.04,2.49c0.31,0.59,0.89,0.87,1.75,0.87c0.4,0.01,0.8-0.07,1.18-0.22 c0.37-0.15,0.72-0.38,1-0.66c0.59-0.62,1.03-1.38,1.26-2.22l0.08-0.31c0.29-1.11,0.26-1.94-0.03-2.53 C40.64,12.44,40.06,12.14,39.23,12.14L39.23,12.14z M26.85,7.81h-3.21l-1.13,4.28h3.21c1.01,0,1.81-0.17,2.35-0.52 c0.57-0.37,0.98-0.95,1.13-1.63c0.2-0.72,0.11-1.27-0.27-1.62C28.55,7.99,27.86,7.81,26.85,7.81L26.85,7.81z" />
                                                <polygon class="strp0"
                                                    points="18.4,0 12.76,21.47 8.89,21.47 12.7,6.93 6.86,10.78 7.9,6.95 18.4,0" />
                                            </g>
                                        </svg>
                                    </span>
                                </x-secondary-button>
                            @endif

                            @if ($paymentGateway->is_qr_payment_enabled && $paymentGateway->qr_code_image_url)
                                <!-- Button -->
                                <x-secondary-button wire:click="toggleQrCode">
                                    <span class="inline-flex items-center">
                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g stroke-width="0" />
                                            <g stroke-linecap="round" stroke-linejoin="round" />
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path
                                                d="M16 17v-1h-3v-3h3v2h2v2h-1v2h-2v2h-2v-3h2v-1zm5 4h-4v-2h2v-2h2zM3 3h8v8H3zm2 2v4h4V5zm8-2h8v8h-8zm2 2v4h4V5zM3 13h8v8H3zm2 2v4h4v-4zm13-2h3v2h-3zM6 6h2v2H6zm0 10h2v2H6zM16 6h2v2h-2z" />
                                        </svg>
                                        <span class="ml-2">@lang('modules.billing.paybyQr')</span>
                                    </span>
                                </x-secondary-button>
                            @endif

                            @if ($paymentGateway->is_offline_payment_enabled && $paymentGateway->offline_payment_detail)
                                <!-- Button -->
                                <x-secondary-button wire:click="togglePaymenntDetail">
                                    <span class="inline-flex items-center">
                                        <svg class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 15V17M6 7H18C18.5523 7 19 7.44772 19 8V16C19 16.5523 18.5523 17 18 17H6C5.44772 17 5 16.5523 5 16V8C5 7.44772 5.44772 7 6 7ZM6 7L18 7C18.5523 7 19 6.55228 19 6V4C19 3.44772 18.5523 3 18 3H6C5.44772 3 5 3.44772 5 4V6C5 6.55228 5.44772 7 6 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 11C13.1046 11 14 10.1046 14 9C14 7.89543 13.1046 7 12 7C10.8954 7 10 7.89543 10 9C10 10.1046 10.8954 11 12 11Z" stroke="currentColor" stroke-width="2"/>
                                        </svg>

                                        <span class="ml-2">@lang('modules.billing.bankTransfer')</span>
                                    </span>
                                </x-secondary-button>
                            @endif

                    </div>
                @endif
            </x-slot>

            <x-slot name="footer">
                <x-button-cancel wire:click="hidePaymentModal" wire:loading.attr="disabled" />
                @if ($showQrCode || $showPaymentDetail)
                <x-button class="ml-3" wire:click="placeOrder(false, {{ $paymentOrder->id }})" wire:loading.attr="disabled">@lang('modules.billing.paymentDone')</x-button>
                @endif
            </x-slot>
        </x-dialog-modal>
    @endif

    <x-dialog-modal wire:model.live="showModifiersModal" maxWidth="xl">
        <x-slot name="title">
            @lang('modules.modifier.itemModifiers')
        </x-slot>

        <x-slot name="content">
            @if ($selectedModifierItem)
                @livewire('pos.itemModifiers', ['menuItemId' => $selectedModifierItem], key(str()->random(50)))
            @endif
        </x-slot>
    </x-dialog-modal>

    @script
        <script>
            $wire.on('paymentInitiated', (payment) => {
                payViaRazorpay(payment);
            });

            $wire.on('stripePaymentInitiated', (payment) => {
                document.getElementById('order_payment').value = payment.payment.id;
                document.getElementById('order-payment-form').submit();
            });

            function payViaRazorpay(payment) {

                var options = {
                    "key": "{{ $restaurant->paymentGateways->razorpay_key }}", // Enter the Key ID generated from the Dashboard
                    "amount": (parseFloat(payment.payment.amount) * 100),
                    "currency": "{{ $restaurant->currency->currency_code }}",
                    "description": "Order Payment",
                    "image": "{{ $restaurant->logoUrl }}",
                    "order_id": payment.payment.razorpay_order_id,
                    "handler": function(response) {
                        Livewire.dispatch('razorpayPaymentCompleted', [response.razorpay_payment_id, response
                            .razorpay_order_id,
                            response.razorpay_signature
                        ]);
                    },
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
            }
        </script>
    @endscript

</div>
