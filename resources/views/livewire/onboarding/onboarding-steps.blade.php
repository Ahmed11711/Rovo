<div class="grid lg:grid-cols-3">
    <style>
        .onboarding-steps .button-cancel {
            display: none
        }
    </style>


    <div class="bg-gray-100 lg:h-screen p-4 sm:flex items-center dark:bg-gray-800 dark:border-gray-700">

        <section class="py-8  md:py-16 px-6">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <div class="mx-auto max-w-3xl space-y-6 sm:space-y-8">

                    <div class="mb-4">
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('app.hello')
                            {{ user()->name }}!</h1>
                    </div>

                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                        @lang('modules.onboarding.completeSteps')</h2>


                    <ol class="relative border-s border-gray-200 dark:border-gray-700 space-y-8">


                        <li class="ms-6">
                            <span
                                class="absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full bg-green-700 ring-8 ring-white dark:bg-green-800 dark:ring-gray-900">
                                <svg class="h-3 w-3 text-green-50 dark:text-green-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                            </span>
                            <h3 class="mb-1.5 text-base font-semibold leading-none text-gray-900 dark:text-white">
                                @lang('modules.onboarding.addBranchHeading')</h3>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 tracking-wide">
                                @lang('modules.onboarding.addBranchInfo')</p>
                        </li>

                        <li class="ms-6">
                            <span @class(['absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full
                                ring-8 ring-white dark:ring-gray-900', 'bg-gray-100 dark:bg-gray-800'=>
                                !$onboardingSteps->add_area_completed, 'bg-green-700 dark:bg-green-800' =>
                                $onboardingSteps->add_area_completed])>
                                <svg aria-hidden="true" @class(['h-3 w-3', 'text-gray-500 dark:text-gray-400'=>
                                    !$onboardingSteps->add_area_completed, 'text-green-50 dark:text-green-400' =>
                                    $onboardingSteps->add_area_completed])
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                            </span>
                            <h3 @class(["mb-1.5 text-base font-semibold leading-none text-gray-900 dark:text-white flex
                                justify-between"])>@lang('modules.onboarding.addAreaHeading')

                                @if ($onboardingSteps->add_area_completed)
                                <a href="javascript:;" wire:click="showAddAreaForm"
                                    class="text-gray-900 bg-gray-300 hover:bg-gray-800 hover:text-white focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-xs px-2.5 py-1 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 dark:text-gray-100">@lang('app.addMore')</a>
                                @endif
                            </h3>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 tracking-wide">
                                @lang('modules.onboarding.addAreaInfo')</p>
                        </li>

                        <li class="ms-6">
                            <span @class(['absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full
                                ring-8 ring-white dark:ring-gray-900', 'bg-gray-100 dark:bg-gray-800'=>
                                !$onboardingSteps->add_table_completed, 'bg-green-700 dark:bg-green-800' =>
                                $onboardingSteps->add_table_completed])>
                                <svg aria-hidden="true" @class(['h-3 w-3', 'text-gray-500 dark:text-gray-400'=>
                                    !$onboardingSteps->add_table_completed, 'text-green-50 dark:text-green-400' =>
                                    $onboardingSteps->add_table_completed])
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                            </span>
                            <h3 @class(["mb-1.5 text-base font-semibold leading-none text-gray-900 dark:text-white flex
                                justify-between"])>@lang('modules.onboarding.addTableHeading')
                                @if ($onboardingSteps->add_table_completed)
                                <a href="javascript:;" wire:click="showAddTableForm"
                                    class="text-gray-900 bg-gray-300 hover:bg-gray-800 hover:text-white focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-xs px-2.5 py-1 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 dark:text-gray-100">@lang('app.addMore')</a>
                                @endif
                            </h3>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 tracking-wide">
                                @lang('modules.onboarding.addTableInfo')</p>
                        </li>

                        <li class="ms-6">
                            <span @class(['absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full
                                ring-8 ring-white dark:ring-gray-900', 'bg-gray-100 dark:bg-gray-800'=>
                                !$onboardingSteps->add_menu_completed, 'bg-green-700 dark:bg-green-800' =>
                                $onboardingSteps->add_menu_completed])>
                                <svg aria-hidden="true" @class(['h-3 w-3', 'text-gray-500 dark:text-gray-400'=>
                                    !$onboardingSteps->add_menu_completed, 'text-green-50 dark:text-green-400' =>
                                    $onboardingSteps->add_menu_completed])
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                            </span>
                            <h3 @class(["mb-1.5 text-base font-semibold leading-none text-gray-900 dark:text-white flex
                                justify-between"])>@lang('modules.onboarding.addMenuHeading')
                                @if ($onboardingSteps->add_menu_completed)
                                <a href="javascript:;" wire:click="showAddMenuForm"
                                    class="text-gray-900 bg-gray-300 hover:bg-gray-800 hover:text-white focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-xs px-2.5 py-1 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 dark:text-gray-100">@lang('app.addMore')</a>
                                @endif
                            </h3>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 tracking-wide">
                                @lang('modules.onboarding.addMenuInfo')</p>
                        </li>

                        <li class="ms-6">
                            <span @class(['absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full
                                ring-8 ring-white dark:ring-gray-900', 'bg-gray-100 dark:bg-gray-800'=>
                                !$onboardingSteps->add_menu_items_completed, 'bg-green-700 dark:bg-green-800' =>
                                $onboardingSteps->add_menu_items_completed])>
                                <svg aria-hidden="true" @class(['h-3 w-3', 'text-gray-500 dark:text-gray-400'=>
                                    !$onboardingSteps->add_menu_items_completed, 'text-green-50 dark:text-green-400' =>
                                    $onboardingSteps->add_menu_items_completed])
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                            </span>
                            <h3 @class(["mb-1.5 text-base font-semibold leading-none text-gray-900 dark:text-white flex
                                justify-between"])>@lang('modules.onboarding.addMenuItemHeading')
                                @if ($onboardingSteps->add_menu_items_completed)
                                <a href="javascript:;" wire:click="showAddMenuItemForm"
                                    class="text-gray-900 bg-gray-300 hover:bg-gray-800 hover:text-white focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-xs px-2.5 py-1 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 dark:text-gray-100">@lang('app.addMore')</a>
                                @endif
                            </h3>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 tracking-wide">
                                @lang('modules.onboarding.addMenuItemInfo')</p>
                        </li>


                    </ol>

                </div>
            </div>
        </section>

    </div>

    <div class="col-span-2 px-8 lg:px-16 flex items-center w-full onboarding-steps">

        @if (!$onboardingSteps->add_area_completed || $showAddArea)
        <div class="space-y-4 w-full">
            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __("modules.table.addArea") }}
            </div>

            @livewire('forms.addArea')
        </div>
        @elseif (!$onboardingSteps->add_table_completed || $showAddTable)
        <div class="space-y-4 w-full">
            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __("modules.table.addTable") }}
            </div>

            @livewire('forms.addTable')
        </div>
        @elseif (!$onboardingSteps->add_menu_completed || $showAddMenu)
        <div class="space-y-4 w-full">
            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __("modules.menu.addMenu") }}
            </div>

            @livewire('forms.addMenu')
        </div>
        @elseif (!$onboardingSteps->add_menu_items_completed || $showAddMenuItem)
        <div class="space-y-4 w-full">
            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __("modules.menu.addMenuItem") }}
            </div>

            @livewire('forms.addMenuItem')
        </div>
        @else
        <div class="space-y-4 w-full">
            <div
                class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 max-w-md mx-auto">
                <div class="h-52 flex flex-col justify-center items-center bg-skin-base rounded-t-xl">
                    <svg class="size-28 transition duration-75 text-gray-50 dark:text-gray-900 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 -0.5 25 25" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd"
                                d="M16,6 L20,6 C21.1045695,6 22,6.8954305 22,8 L22,16 C22,17.1045695 21.1045695,18 20,18 L16,18 L16,19.9411765 C16,21.0658573 15.1177541,22 14,22 L4,22 C2.88224586,22 2,21.0658573 2,19.9411765 L2,4.05882353 C2,2.93414267 2.88224586,2 4,2 L14,2 C15.1177541,2 16,2.93414267 16,4.05882353 L16,6 Z M20,11 L16,11 L16,16 L20,16 L20,11 Z M14,19.9411765 L14,4.05882353 C14,4.01396021 13.9868154,4 14,4 L4,4 C4.01318464,4 4,4.01396021 4,4.05882353 L4,19.9411765 C4,19.9860398 4.01318464,20 4,20 L14,20 C13.9868154,20 14,19.9860398 14,19.9411765 Z M5,19 L5,17 L7,17 L7,19 L5,19 Z M8,19 L8,17 L10,17 L10,19 L8,19 Z M11,19 L11,17 L13,17 L13,19 L11,19 Z M5,16 L5,14 L7,14 L7,16 L5,16 Z M8,16 L8,14 L10,14 L10,16 L8,16 Z M11,16 L11,14 L13,14 L13,16 L11,16 Z M13,5 L13,13 L5,13 L5,5 L13,5 Z M7,7 L7,11 L11,11 L11,7 L7,7 Z M20,9 L20,8 L16,8 L16,9 L20,9 Z">
                            </path>
                        </g>
                    </svg>
                </div>
                <div class="p-4 md:p-6">

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                        @lang('modules.onboarding.addOrderHeading')
                    </h3>
                    <p class="mt-3 text-gray-500 dark:text-neutral-500">
                        @lang('modules.onboarding.addOrderInfo')
                    </p>
                </div>
                <div
                    class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                    <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-base font-semibold rounded-es-xl bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                        href="{{ route('pos.index') }}" wire:navigate>
                        @lang('modules.order.placeOrder')
                    </a>

                </div>
            </div>
            <!-- End Card -->
        </div>
        @endif

    </div>



</div>