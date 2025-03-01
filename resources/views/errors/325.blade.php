<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('errors.325.title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <style>
        /* Ensure smooth transitions */
        .theme-transition {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="h-full theme-transition" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'bg-gray-50 text-gray-900': !darkMode, 'bg-gray-900 text-white': darkMode }">
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Theme Toggle Button -->
    <button
        @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
        class="fixed top-4 right-4 p-2 rounded-lg theme-transition"
        :class="darkMode ? 'bg-gray-700 text-gray-200' : 'bg-gray-200 text-gray-800'"
    >
        <!-- Sun icon -->
        <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <!-- Moon icon -->
        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>

    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg space-y-8">
            <!-- Error Icon -->
            <div class="mx-auto w-24 h-24 rounded-full theme-transition"
                 :class="darkMode ? 'bg-red-500/20' : 'bg-red-100'">
                <div class="flex items-center justify-center h-full">
                    <svg class="w-12 h-12 theme-transition" :class="darkMode ? 'text-red-400' : 'text-red-600'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold tracking-tight theme-transition"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    {{ __('errors.325.title') }}
                </h2>
                <p class="mt-2 text-sm theme-transition"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    {{ __('errors.325.message') }}
                </p>
                <p class="mt-2 text-sm theme-transition"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    {{ __('errors.325.suggestion') }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 space-y-4">
                <a href="{{ route('restaurant_signup') }}"
                   class="group relative flex w-full justify-center rounded-lg px-4 py-4 text-sm font-semibold text-white theme-transition"
                   :class="darkMode ? 'bg-purple-600 hover:bg-purple-500' : 'bg-indigo-600 hover:bg-indigo-500'">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 theme-transition" :class="darkMode ? 'text-purple-300' : 'text-indigo-300'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </span>
                    {{ __('errors.325.create_account') }}
                </a>

                <a href="{{ route('front.forgot-restaurant') }}"
                   class="group relative flex w-full justify-center rounded-lg px-4 py-4 text-sm font-semibold border theme-transition"
                   :class="darkMode ? 'bg-gray-700 text-white hover:bg-gray-600 border-gray-600' : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 theme-transition" :class="darkMode ? 'text-gray-300' : 'text-gray-400'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </span>
                    {{ __('errors.325.find_url') }}
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm theme-transition"
                 :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                <p>{{ __('errors.325.need_help') }}</p>
            </div>
        </div>
    </div>

    <script>
        // Check initial dark mode on page load
        document.addEventListener('DOMContentLoaded', () => {
            const darkMode = localStorage.getItem('darkMode') === 'true';
            if (darkMode) {
                document.body.setAttribute('x-data', '{ darkMode: true }');
            }
        });
    </script>
</body>
</html>
