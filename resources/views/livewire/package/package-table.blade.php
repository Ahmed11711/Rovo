<div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('app.id')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.package.packageName')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.package.monthlyPrice')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.package.annualPrice')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.package.lifetimePrice')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.package.moduleInPackage')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='member-list-{{ microtime() }}'>

                            @forelse ($packages as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='member-{{ $item->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex flex-col items-start gap-y-1">
                                        <span class="inline-flex items-center">
                                            {{ $item->package_name}}
                                            @if(in_array($item->package_type->value, ['trial', 'default']))
                                            <svg data-popover-target="popover-{{$item->package_type->value}}-pack" data-popover-placement="bottom-end" class="w-4 h-4 text-gray-400 ms-1 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                                            <div data-popover id="popover-{{$item->package_type->value}}-pack" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-600 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 text-wrap w-52 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                                <div class="p-3 space-y-2 break-words">
                                                    @if($item->package_type->value === 'trial')
                                                        <h3 class="font-semibold text-gray-900 dark:text-white">@lang('modules.package.trialPackage')</h3>
                                                        <p>@lang('modules.package.trialPackageDetails')</p>
                                                    @elseif($item->package_type->value === 'default')
                                                        <h3 class="font-semibold text-gray-900 dark:text-white">@lang('modules.package.defaultPackage')</h3>
                                                        <p>@lang('modules.package.defaultPackageDetails')</p>
                                                        <p>@lang('modules.package.defaultPackageDetails2')</p>
                                                    @endif
                                                    <p>@lang('modules.package.thisPackageCannotBeDeleted')</p>
                                                </div>
                                                <div data-popper-arrow></div>
                                            </div>
                                            @endif
                                        </span>
                                        <div class="flex items-center gap-x-1">
                                            @if($item->is_recommended)
                                            <span class="bg-blue-500 text-white inline-flex text-xs font-medium items-center px-1 rounded gap-x-0.5 dark:bg-blue-700 border border-blue-500">
                                                <svg class="w-3 h-3 text-current" width="24" height="24" fill="currentColor" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg"><path d="m7.5 0-2 5h-5l4 3.5-2 6 5-3.5 5 3.5-2-6 4-3.5h-5z"/></svg>
                                                @lang('modules.package.recommended')
                                            </span>

                                            @endif

                                            @if($item->is_private)
                                            <span class="bg-red-500 text-white inline-flex text-xs font-medium items-center px-1 rounded gap-x-0.5 dark:bg-red-700 border border-red-500">
                                                <svg class="w-4 h-4 text-current" width="16" height="16" fill="currentColor" viewBox="-64 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M96 416q-13 0-22-9-10-10-10-23V224q0-13 10-22 9-10 22-10v-32q0-62 48-84 24-11 47-11 40 0 69 27 28 26 28 69v31q14 0 23 9t9 23v160q0 14-9 23t-23 9zm145-256q0-20-14-33t-35-13q-20 0-33 14-14 13-14 32l-1 64h97z"/></svg>
                                                @lang('modules.package.private')
                                            </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-x-0.5">
                                            @if ($item->package_type->value == 'trial')
                                            <span class="bg-amber-500 text-white inline-flex text-xs font-medium items-center px-1 rounded gap-x-0.5 dark:bg-amber-600 border border-amber-500">
                                                <svg class="w-2.5 h-2.5 me-0.5 text-current" aria-hidden="true" height="16px" width="16px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.01 10.01 0 0 0 10 0m3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1 1 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414"/></svg>
                                                @lang('modules.package.trial')
                                            </span>
                                            @elseif($item->package_type->value == 'lifetime')
                                            <span class="bg-indigo-500 text-white inline-flex text-xs font-medium items-center px-1 rounded gap-x-0.5 dark:bg-indigo-600 border border-indigo-500">
                                                <svg class="w-3 h-3 text-current" width="24" height="24" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"/><g stroke-linecap="round" stroke-linejoin="round"/><path d="m31.89 14.55-4-8A1 1 0 0 0 27 6H5a1 1 0 0 0-.89.55l-4 8a.3.3 0 0 1 0 .09 2 2 0 0 0 0 .26S0 15 0 15v.05a1.3 1.3 0 0 0 .06.28s0 .05 0 .08a.8.8 0 0 0 .18.27l15 16a1 1 0 0 0 1.46 0l15-16a1 1 0 0 0 .19-1.13M16 8.89 19.2 14h-6.4Zm-5.08 4.34L7 8h7.2ZM17.8 8H25l-3.92 5.23Zm1.84 8L16 27.65 12.36 16Zm-5.89 11.14L3.31 16h7Zm8-11.14h7l-10.5 11.14Zm7.65-2H23l3.83-5.11ZM5.17 8.89 9 14H2.62ZM16 4a1 1 0 0 0 1-1V1a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1m-5.71-.29a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-1-1a1 1 0 0 0-1.42 1.42ZM21 4a1 1 0 0 0 .71-.29l1-1a1 1 0 1 0-1.42-1.42l-1 1a1 1 0 0 0 0 1.42A1 1 0 0 0 21 4" data-name="6. Diamond"/></svg>
                                                @lang('modules.package.lifetime')
                                            </span>
                                            @endif

                                            @if($item->package_type->value == 'trial')
                                            <span @class([
                                                'text-white inline-flex text-xs font-medium items-center px-1 rounded ms-1',
                                                'bg-green-500 dark:bg-green-700 border border-green-500' => $item->trial_status == true,
                                                'bg-red-500 dark:bg-red-700 border border-red-500' => $item->trial_status == false
                                            ])>
                                            {{ $item->trial_status == true ? __('app.active') : __('app.inactive') }}
                                            </span>

                                            @endif
                                        </div>
                                        @if($item->package_type->value == 'trial' && $item->trial_days)
                                        <span class="inline-flex items-center px-1 text-xs font-medium text-white bg-gray-500 border border-gray-500 rounded dark:bg-gray-700">
                                            @lang('modules.package.trialPeriod'): {{ $item->trial_days }} @lang('modules.package.days')
                                        </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ global_currency_format($item->monthly_price, $item->currency_id) }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ global_currency_format($item->annual_price, $item->currency_id) }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ global_currency_format($item->price, $item->currency_id) }}
                                </td>

                                <td class="p-2 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                                        @foreach ($allModules as $module)
                                            <div class="flex items-center space-x-0.5 text-wrap w-fit text-xs">
                                                @if($item->modules->contains('id', $module->id))
                                                    <svg class="flex-shrink-0 w-4 h-4 text-green-500" width="24px" height="24px" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon flat-color"><path d="M10 18a1 1 0 0 1-.71-.29l-5-5a1 1 0 0 1 1.42-1.42l4.29 4.3 8.29-8.3a1 1 0 1 1 1.42 1.42l-9 9A1 1 0 0 1 10 18"/></svg>
                                                @else
                                                    <svg class="flex-shrink-0 w-3 h-3 text-red-500" width="24px" height="24px" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M20 20 4 4m16 0L4 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                @endif
                                                <span class="break-words">{{ $module->name }}</span>
                                            </div>
                                        @endforeach

                                        @php $existFeatures = collect(json_decode($item->additional_features, true) ?? []); @endphp

                                        @foreach ($additionalFeatures as $feature)
                                            @php $isActive = $existFeatures->contains($feature); @endphp
                                            <div class="flex items-center space-x-0.5 text-wrap w-fit text-xs">
                                                <svg class="flex-shrink-0 w-4 h-4 {{ $isActive ? 'text-green-500' : 'text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                    @if ($isActive)
                                                    <path d="M10 18a1 1 0 0 1-.71-.29l-5-5a1 1 0 0 1 1.42-1.42l4.29 4.3 8.29-8.3a1 1 0 1 1 1.42 1.42l-9 9A1 1 0 0 1 10 18" />
                                                    @else
                                                    <path d="M20 20L4 4m16 0L4 20" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                    @endif
                                                </svg>
                                                <span class="break-words">{{ $feature }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right rtl:space-x-reverse">
                                    <x-secondary-link href="{{ route('superadmin.packages.edit', $item->id) }}" wire:navigate class="text-blue-600 hover:underline">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                            </path>
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                        </svg>  @lang('app.update')
                                    </x-secondary-link>

                                    @if($item->package_type->isDeletable())
                                    <x-danger-button wire:click="showDeletePackage({{ $item->id }})" wire:key='package-del-{{ $item->id . microtime() }}'>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </x-danger-button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 space-x-6 dark:text-gray-400" colspan="7">
                                    @lang('messages.noPackageFound')
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div wire:key='package-table-paginate-{{ microtime() }}'
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center w-full mb-4 sm:mb-0">
            {{ $packages->links() }}
        </div>
    </div>

    <x-confirmation-modal wire:model="confirmDeletePackageModal">
        <x-slot name="title">
            @lang('modules.package.deletePackage')
        </x-slot>

        <x-slot name="content">
            @lang('modules.package.deletePackageMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmDeletePackageModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>

            @if ($packageDelete)
            <x-danger-button class="ml-3" wire:click='deletePackage({{ $packageDelete->id }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
        </x-slot>
    </x-confirmation-modal>
</div>
