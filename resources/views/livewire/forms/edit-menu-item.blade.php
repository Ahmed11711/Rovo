<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">

            <div>
                <x-label for="itemName" :value="__('modules.menu.itemName')"/>
                <x-input id="itemName" class="block mt-1 w-full" type="text"
                         placeholder="{{ __('placeholders.menuItemNamePlaceholder') }}" name="itemName" autofocus
                         wire:model='itemName'/>
                <x-input-error for="itemName" class="mt-2"/>
            </div>

            <div>
                <x-label for="itemDescription" :value="__('modules.menu.itemDescription')"/>
                <x-textarea class="block mt-1 w-full" :placeholder="__('placeholders.itemDescriptionPlaceholder')"
                            wire:model='itemDescription' rows='2'/>
                <x-input-error for="itemDescription" class="mt-2"/>
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-label for="menu" :value="__('modules.menu.chooseMenu')"/>
                    <x-select id="menu" class="mt-1 block w-full" wire:model="menu">
                        <option value="">--</option>
                        @foreach ($menus as $item)
                            <option value="{{ $item->id }}">{{ $item->menu_name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="menu" class="mt-2"/>
                </div>

                <div>
                    <x-label for="itemCategory" :value="__('modules.menu.itemCategory')"/>
                    <x-select id="itemCategory" name="item_category_id" class="mt-1 block w-full"
                              wire:model="itemCategory">
                        <option value="">--</option>
                        @foreach ($categoryList as $item)
                            <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                        @endforeach

                        <x-slot name="append">
                            <button class="font-semibold border-l-0 text-sm"
                                    wire:click="showMenuCategoryModal" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-gear-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                </svg>
                            </button>
                        </x-slot>
                    </x-select>
                    <x-input-error for="itemCategory" class="mt-2"/>
                </div>
            </div>

            <div>
                <ul class="grid w-full gap-2 grid-cols-3">
                    <li>
                        <input type="radio" id="typeVeg" name="itemType" value="veg" class="hidden peer"
                               wire:model='itemType'>
                        <label for="typeVeg"
                               class="inline-flex items-center justify-between w-full p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-skin-base peer-checked:border-skin-base peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            <img src="{{ asset('img/veg.svg')}}" class="h-5 mr-1"/>
                            @lang('modules.menu.typeVeg')
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="typeNonVeg" name="itemType" value="non-veg" class="hidden peer"
                               wire:model='itemType'/>
                        <label for="typeNonVeg"
                               class="inline-flex items-center justify-between w-full p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-skin-base peer-checked:border-skin-base peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            <img src="{{ asset('img/non-veg.svg')}}" class="h-5 mr-1"/>
                            @lang('modules.menu.typeNonVeg')
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="typeEgg" name="itemType" value="egg" class="hidden peer"
                               wire:model='itemType'>
                        <label for="typeEgg"
                               class="inline-flex items-center justify-between w-full p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-skin-base peer-checked:border-skin-base peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            <img src="{{ asset('img/egg.svg')}}" class="h-5 mr-1"/>
                            @lang('modules.menu.typeEgg')
                        </label>
                    </li>
                     <li>
                        <input type="radio" id="typeDrink" name="itemType" value="drink" class="hidden peer"
                            wire:model='itemType'>
                        <label for="typeDrink"
                            class="inline-flex items-center justify-between w-full p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-skin-base peer-checked:border-skin-base peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            <img src="{{ asset('img/drink.svg')}}" class="h-5 mr-1" />
                            @lang('modules.menu.typeDrink')
                        </label>
                    </li>
                      <li>
                        <input type="radio" id="typeOther" name="itemType" value="other" class="hidden peer"
                            wire:model='itemType'>
                        <label for="typeOther"
                            class="inline-flex items-center justify-between w-full p-2 text-gray-600 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-skin-base peer-checked:border-skin-base peer-checked:text-gray-900 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-medium">
                            {{-- <img src="{{ asset('img/egg.svg')}}" class="h-5 mr-1" /> --}}
                            @lang('modules.menu.typeOther')
                        </label>
                    </li>
                </ul>


            </div>

            <div>
                <x-label for="preparationTime" :value="__('modules.menu.preparationTime')" />
                <div class="relative rounded-md mt-1">
                    <x-input id="preparationTime" type="number" step="1" wire:model="preparationTime"
                        class="block w-full rounded text-gray-900 placeholder:text-gray-400" placeholder="0" />

                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-8">
                        <span class="text-gray-500">@lang('modules.menu.minutes')</span>
                    </div>

                </div>
                <x-input-error for="preparationTime" class="mt-2" />
            </div>

            <div>
                <x-label for="isAvailable" :value="__('modules.menu.isAvailable')" />
                <x-select id="isAvailable" class="mt-1 block w-full" wire:model="isAvailable">
                    <option value="1">@lang('app.yes')</option>
                    <option value="0">@lang('app.no')</option>
                </x-select>
                <x-input-error for="isAvailable" class="mt-2" />
            </div>

            <div>
                <x-label for="itemImage" value="{{ __('modules.menu.itemImage') }}"/>

                <input
                    class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 text-slate-500 my-1"
                    type="file" wire:model="itemImage">

                @if ($menuItem->image)
                    <img class="w-20 h-20 rounded-md object-cover" src="{{ $menuItem->item_photo_url }}"
                         alt="{{ $menuItem->item_name }}">
                @endif

                <x-input-error for="itemImage" class="mt-2"/>
            </div>

            <div>
                <x-label for="hasVariations">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="hasVariations" id="hasVariations" wire:model='hasVariations'
                                    wire:change="checkVariations()"/>

                        <div class="ms-2">
                            @lang('modules.menu.hasVariations')
                        </div>
                    </div>
                </x-label>
            </div>

            @if ($showItemPrice)
                <div wire:transition.out.opacity.duration.200ms>
                    <x-label for="itemPrice" :value="__('modules.menu.setPrice')"/>
                    <div class="relative rounded-md mt-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500">{{ currency() }}</span>
                        </div>
                        <x-input id="itemPrice" type="number" step="0.001" wire:model="itemPrice"
                                 class="block w-full rounded pl-7 text-gray-900 placeholder:text-gray-400"
                                 placeholder="0.00"/>
                    </div>
                    <x-input-error for="itemPrice" class="mt-2"/>
                </div>
            @endif

            @if (!$showItemPrice)
                <div>
                    @foreach($inputs as $key => $value)
                        <div class="grid grid-cols-2 gap-4 mb-4" wire:key='variation-item-{{ $value }}'>
                            <div>
                                <x-label for="variationName.{{ $key }}" :value="__('modules.menu.variationName')"/>

                                <x-input id="variationName.{{ $key }}" class="block mt-1 w-full" type="text"
                                         placeholder="{{ __('placeholders.itemVariationPlaceholder') }}" autofocus
                                         wire:model='variationName.{{ $key }}'/>

                                <x-input-error for="variationName.{{ $key }}" class="mt-2"/>
                            </div>
                            <div>
                                <x-label for="variationPrice.{{ $key }}" :value="__('modules.menu.setPrice')"/>
                                <div class="relative rounded-md mt-1 inline-flex items-center">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500">{{ currency() }}</span>
                                    </div>
                                    <x-input id="variationPrice.{{ $key }}" type="number" step="0.001"
                                             wire:model="variationPrice.{{ $key }}"
                                             class="block w-full rounded pl-7 text-gray-900 placeholder:text-gray-400"
                                             placeholder="0.00"/>

                                    <x-danger-button class="ml-2" wire:click="removeField({{ $key }})"
                                                     wire:key='remove-variation-{{ $key.rand() }}'>&cross;
                                    </x-danger-button>
                                </div>
                                <x-input-error for="variationPrice.{{ $key }}" class="mt-2"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($hasVariations)
                <x-secondary-button wire:click="addMoreField({{ $i }})">@lang('modules.menu.addVariations')
                </x-secondary-button>
            @endif

        </div>

        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel wire:click="$dispatch('hideEditMenuItem')">@lang('app.cancel')</x-button-cancel>
        </div>

    </form>


</div>
