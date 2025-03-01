@extends('layouts.app')

@section('content')

<div class="p-4 bg-white block  dark:bg-gray-800 dark:border-gray-700">
    @include('dashboard.update-message-dashboard')

    <x-cron-message  :showModal="false" :modal="true"/>

    @if(smtp_setting()->mail_driver == 'smtp' && !smtp_setting()->verified)
        <x-alert type="danger" icon="info-circle">
            <div class="flex items-center gap-2">
                @lang('messages.smtpError')

                <x-secondary-link href="{{ route('superadmin.superadmin-settings.index').'?tab=email' }}">
                    @lang('modules.settings.emailSettings')
                </x-secondary-link>
            </div>
        </x-alert>
    @endif

    <div class="flex justify-between">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.dashboard')</h1>

        <div class="inline-flex items-center gap-1 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-event" viewBox="0 0 16 16">
                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
            </svg>

            {{ now()->timezone(timezone())->translatedFormat('l, d M, h:i A') }}
        </div>
    </div>
</div>

<div class="grid grid-cols-1">

    <div class="p-4">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-xl dark:text-white my-2 ">@lang('modules.dashboard.todayStats')</h1>

        <div class="grid w-full grid-cols-1 gap-4 xl:grid-cols-2">


            @livewire('dashboard.restaurantCount')

            @livewire('dashboard.totalRestaurantCount')

            @livewire('dashboard.totalFreeRestaurantCount')

            @livewire('dashboard.totalPaidRestaurantCount')


        </div>

    </div>

</div>


@endsection
