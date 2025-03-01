<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 rounded-lg mb-4">

    <div class="w-full sm:max-w-md lg:max-w-screen-lg mt-6 px-6 py-4  overflow-hidden sm:rounded-lg grid lg:grid-cols-2 gap-6 items-center">
        <section class="hidden lg:block">

            <div class="mx-auto w-full flex">
                {{ $logo }}
            </div>

            <div class="gap-8 items-center py-6 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2">

                <div class="mt-5 sm:mt-10 lg:mt-0 lg:col-span-5">
                    <div class="space-y-6 sm:space-y-8">
                      <!-- Title -->
                      <div class="space-y-2 md:space-y-4">
                        <h2 class="font-bold text-2xl text-gray-800 dark:text-neutral-200">
                            @lang('landing.featureSection1')
                        </h2>

                      </div>
                      <!-- End Title -->

                      <!-- List -->
                      <ul class="space-y-2 sm:space-y-4">
                        <li class="flex gap-x-3 items-center">
                          <span class="size-4 flex justify-center items-center rounded-full bg-rose-of-sharon-600 text-rose-of-sharon-50 dark:bg-rose-of-sharon-800/30 dark:text-rose-of-sharon-500">
                            <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                          </span>
                          <div class="grow">
                            <span class="text-sm sm:text-base text-gray-700 dark:text-neutral-400">
                                @lang('landing.featureTitle1')
                            </span>
                          </div>
                        </li>

                        <li class="flex gap-x-3 items-center">
                            <span class="size-4 flex justify-center items-center rounded-full bg-rose-of-sharon-600 text-rose-of-sharon-50 dark:bg-rose-of-sharon-800/30 dark:text-rose-of-sharon-500">
                              <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                          <div class="grow">
                            <span class="text-sm sm:text-base text-gray-700 dark:text-neutral-400">
                                @lang('landing.featureTitle2')
                            </span>
                          </div>
                        </li>

                        <li class="flex gap-x-3 items-center">
                            <span class="size-4 flex justify-center items-center rounded-full bg-rose-of-sharon-600 text-rose-of-sharon-50 dark:bg-rose-of-sharon-800/30 dark:text-rose-of-sharon-500">
                              <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                          <div class="grow">
                            <span class="text-sm sm:text-base text-gray-700 dark:text-neutral-400">
                                @lang('landing.featureTitle3')
                            </span>
                          </div>
                        </li>
                      </ul>
                      <!-- End List -->
                    </div>
                  </div>

            </div>
        </section>

        {{ $slot }}
    </div>
</div>
