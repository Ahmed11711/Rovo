@extends('layouts.app')

@section('content')


<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-2 xl:gap-4 dark:bg-gray-900">
        <div class="mb-4 col-span-full xl:mb-2">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.appUpdate')</h1>
        </div>
    </div>

    <div class="flex w-full flex-col p-4">
        @php($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo())
        @include('vendor.froiden-envato.update.update_blade')
        @include('vendor.froiden-envato.update.version_info')
        @include('vendor.froiden-envato.update.changelog')
    </div>


</div>


@endsection


@push('scripts')
    @include('vendor.froiden-envato.update.update_script')
@endpush
