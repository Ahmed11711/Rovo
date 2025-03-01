@extends('layouts.app')

@section('content')


<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-2 xl:gap-4 dark:bg-gray-900">
        <div class="mb-4 col-span-full xl:mb-2">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.appUpdate')</h1>
        </div>
    </div>

    <div class="p-2 ">
        <x-alert type="warning">
            @lang('modules.dashboard.verificationPendingInfo')</p>
        </x-alert>
    </div>

    <div class="p-2 text-center">
        <div class="mb-4">
            <img src="{{ asset('img/pending_approval.svg') }}" width="350" alt="@lang('modules.dashboard.verificationPending')" class="mx-auto">
        </div>
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-2">
            @lang('modules.dashboard.verificationPending')
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            @lang('modules.dashboard.verificationPendingDescription')
        </p>
    </div>

</div>


@endsection


@push('scripts')
    @include('vendor.froiden-envato.update.update_script')
@endpush
