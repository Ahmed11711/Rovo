<style>

    #sidebar ul li {
        list-style: none;
    }

    .-color-primary {
        -webkit-box-shadow: 0 2px 0 #6f9a37;
        box-shadow: 0 2px 0 #6f9a37;
        position: relative;
    }

</style>


<div class="support-div mb-2 ">
    @if (!is_null($envatoUpdateCompanySetting->supported_until))

        @php
            $expired = Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->isPast();
            $support = Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until);
        @endphp

        
        <x-alert type="{{ (!$expired) ? 'success' : 'danger' }}">
            <div class="flex justify-between w-full items-center">
                <div class="mt-4">
                    <div class="col-md-12">
                        <div class="item-support-extension__row1 mb-2">
                            <div class="item-support-extension__label">
                                @if($expired)
                                    <p>Renew support to get help from <a href="https://1.envato.market/froiden" target="_blank">Author</a>
                                        for 6 months</p>
                                @elseif((int)now()->diffInDays($support) < 90)
                                    <p class="mt-3">Get an extra 6 months of support now and save <strong>62.5%</strong> of item price.</p>
                                @endif
                                @include('custom-modules.sections.support-date',['fetchSetting' => $envatoUpdateCompanySetting])
                            </div>
                        </div>


                        @if($expired)
                            <a class="text-white justify-center bg-skin-base hover:bg-skin-base/[.8] sm:w-auto dark:bg-skin-base dark:hover:bg-skin-base/[.8] font-semibold rounded-lg text-sm px-5 py-2.5 text-center mr-2  -color-primary -size-m -width-full h-mt"
                                                  href="{{\Froiden\Envato\Helpers\FroidenApp::renewSupportUrl(config('froiden_envato.envato_item_id'))}}"

                                                  target="_blank">Renew support now
                            </a>
                            <x-secondary-button link="javascript:;"
                                                    class=" -color-primary -size-m -width-full h-mt"
                                                    onclick="getPurchaseData();"
                                                    data-toggle="tooltip"
                                                    data-original-title="This will fetch the latest support date from codecanyon. Click on this button only when you have renewed the support and the new support date is not reflecting"
                                                    icon="sync-alt">Refresh
                            </x-secondary-button>
                        @elseif ((int)now()->diffInDays($support) < 90)
                            <a class="text-white justify-center bg-skin-base hover:bg-skin-base/[.8] sm:w-auto dark:bg-skin-base dark:hover:bg-skin-base/[.8] font-semibold rounded-lg text-sm px-5 py-2.5 text-center mr-2"
                                                  href="{{ Froiden\Envato\Helpers\FroidenApp::extendSupportUrl(config('froiden_envato.envato_item_id')) }}"
                                                  target="_blank"
                                                  >Extend now and save
                            </a>

                            <a href="javascript:;"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg font-semibold text-sm text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 "  onclick="getPurchaseData();"
                            >Refresh
                        </a>

                        @endif
                    </div>
                </div>
                <div class="text-center">
                    <div class="">
                        <h2 class="mb-0 text-[21px] font-normal capitalize">
                            <strong>Support @if($expired) Expired @endif
                            </strong>
                        </h2>
                    </div>
                    <div class="mt-1">
                        <span class="text-center">
                             @if($expired)
                                {{ $support->diffForHumans(now(),Carbon\CarbonInterface::DIFF_ABSOLUTE) }} ago
                            @else
                                {{ $support->diffForHumans(now(),Carbon\CarbonInterface::DIFF_ABSOLUTE) }} left
                            @endif
                        </span>

                    </div>
                </div>
            </div>
        </x-alert>


    @endif
</div>

