<x-auth-layout>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">

        <x-validation-errors class="mb-4"/>

        @session('status')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ $value }}
        </div>
        @endsession

        @livewire('forms.restaurantSignup')

    </div>

    @if (languages()->count() > 1)
    <div class="mt-4">
        @livewire('shop.languageSwitcher')
    </div>
    @endif

</x-auth-layout>
