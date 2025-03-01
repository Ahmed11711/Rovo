<div>
    <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px">

            <li class="me-2">
                <a href="{{ route('superadmin.superadmin-settings.index') }}" wire:navigate
                @class(["inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activeSetting != 'app'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activeSetting == 'app')])>@lang('modules.settings.appSettings')</a>
            </li>


            <li class="me-2">
                <a href="{{ route('superadmin.superadmin-settings.index').'?tab=email' }}" wire:navigate
                @class(["inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activeSetting != 'email'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activeSetting == 'email')])>@lang('modules.settings.emailSettings')</a>
            </li>

            <li class="me-2">
                <a href="{{ route('superadmin.superadmin-settings.index').'?tab=language' }}" wire:navigate
                @class(["inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activeSetting != 'language'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activeSetting == 'language')])>@lang('modules.settings.languageSettings')</a>
            </li>

            <li class="me-2">
                <a href="{{ route('superadmin.superadmin-settings.index').'?tab=payment' }}" wire:navigate
                @class(["inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activeSetting != 'payment'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activeSetting == 'payment')])>@lang('modules.settings.paymentgatewaySettings')</a>
            </li>

              <li class="me-2">
                <a href="{{ route('superadmin.superadmin-settings.index').'?tab=theme' }}" wire:navigate
                @class(["inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activeSetting != 'theme'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activeSetting == 'theme')])>@lang('modules.settings.themeSettings')</a>
            </li>

            <li class="me-2">
                <a href="{{ route('superadmin.superadmin-settings.index').'?tab=push' }}" wire:navigate
                @class(["inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activeSetting != 'push'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activeSetting == 'push')])>@lang('modules.settings.pushNotificationSettings')</a>
            </li>

            <li class="me-2">
                <a href="{{ route('superadmin.superadmin-settings.index').'?tab=currency' }}" wire:navigate
                @class(["inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activeSetting != 'currency'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activeSetting == 'currency')])>@lang('modules.settings.currencySettings')</a>
            </li>

            <li class="me-2">
                <a href="{{ route('superadmin.superadmin-settings.index').'?tab=storage' }}" wire:navigate
                @class(["inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activeSetting != 'storage'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activeSetting == 'storage')])>@lang('modules.settings.storageSettings')</a>
            </li>

            <!-- NAV ITEM - CUSTOM MODULES  -->
            @foreach (custom_module_plugins() as $item)
                @includeIf(strtolower($item) . '::sections.superadmin-settings.sidebar')
            @endforeach

        </ul>
    </div>

    <div class="grid grid-cols-1 pt-6 dark:bg-gray-900">

        <div>
            @switch($activeSetting)
                @case('app')
                @livewire('superadminSettings.appSettings', ['settings' => $settings])
                @break

                @case('email')
                @livewire('settings.emailSettings', ['settings' => $settings])
                @break

                @case('language')
                @livewire('settings.languageSettings')
                @break

                @case('payment')
                @livewire('settings.SuperadminPaymentSettings', ['settings' => $settings])
                @break

                @case('theme')
                @livewire('settings.SuperadminThemeSettings', ['settings' => $settings])
                @break

                @case('push')
                @livewire('settings.pushNotificationSettings', ['settings' => $settings])
                @break

                @case('currency')
                @livewire('settings.SuperadminCurrencySettings', ['settings' => $settings])
                @break

                @case('storage')
                @livewire('settings.storageSettings')
                @break

                @default

            @endswitch

              <!-- NAV ITEM - CUSTOM MODULES  -->
              @foreach (custom_module_plugins() as $item)
              @if($activeSetting == $item)
                @livewire($item.'::super-admin.setting')
              @endif
          @endforeach

        </div>


    </div>

</div>
