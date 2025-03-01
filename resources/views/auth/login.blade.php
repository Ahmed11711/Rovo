<x-auth-layout>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

        <x-validation-errors class="mb-4"/>

        @session('status')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ $value }}
        </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('app.email') }}"/>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                         autofocus autocomplete="username"/>
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('app.password') }}"/>
                <x-input-password id="password" class="block mt-1 w-full" type="password" name="password" required
                          :autocomplete="false" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="block">
                    <label for="remember_me" class="flex items-center cursor-pointer">
                        <x-checkbox id="remember_me" name="remember"/>
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('app.rememberMe') }}</span>
                    </label>
                </div>
                <div>
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                       href="{{ route('password.request') }}">
                        {{ __('app.forgotPassword') }}
                    </a>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">@lang('auth.areYouNew', ['appName' => global_setting()->name]) <a href="{{ route('restaurant_signup') }}"
                    class="underline underline-offset-1 font-medium">@lang('auth.createAccount')</a></div>

                <x-button class="ms-4 button" >
                    <svg aria-hidden="true" class="hidden inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    {{ __('app.login') }}
                </x-button>

            </div>

            @if(!module_enabled('Subdomain') && !global_setting()->disable_landing_site)
            <div class="flex items-center justify-center mt-4">
                <a href="{{ route('home') }}"
                   class="text-sm text-gray-500 underline underline-offset-1">

                    @lang('auth.goHome')
                </a>
            </div>
            @endif

        </form>
    </div>

    @if (languages()->count() > 1)
    <div class="mt-4">
        @livewire('shop.languageSwitcher')
    </div>
    @endif

    <script>

        document.querySelector('.button').addEventListener('click', () => {
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');
            const button = document.querySelector('.button');

            if (emailField.checkValidity() && passwordField.checkValidity() && emailField.value && passwordField.value) {
                button.classList.add('opacity-50', 'cursor-not-allowed');
                button.innerHTML = `<svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg> @lang('app.loading')`;
            }
        });

    </script>

</x-auth-layout>
