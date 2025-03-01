@extends('layouts.app')

@section('content')

<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-2 xl:gap-4 dark:bg-gray-900">
        <div class="mb-4 col-span-full xl:mb-2">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('modules.settings.customModules')</h1>
        </div>
    </div>

    <div class="flex w-full flex-col p-4">
        @include($view)
    </div>
</div>

@endsection




@push('scripts')
    <script>
        /* manage menu active class */
        $('.nav-item').removeClass('active');
        const activeTab = "{{ $activeTab }}";
        $('.' + activeTab).addClass('active');

        showBtn(activeTab);

        function showBtn(activeTab) {
            $('.actionBtn').addClass('d-none');
            $('.' + activeTab + '-btn').removeClass('d-none');
        }

        $("body").on("click", "#editSettings .nav a", function(event) {
            event.preventDefault();

            $('.nav-item').removeClass('active');
            $(this).addClass('active');

            const requestUrl = this.href;

            $.easyAjax({
                url: requestUrl,
                blockUI: true,
                container: "#nav-tabContent",
                historyPush: true,
                success: function(response) {
                    if (response.status == "success") {
                        showBtn(response.activeTab);

                        $('#nav-tabContent').html(response.html);
                        init('#nav-tabContent');
                    }
                }
            });
        });


        /* change module setting */
        $('body').on('change', '.change-module-setting', function() {

            var id = $(this).data('setting-id');
            var name = $(this).data('module-name');

            if(name == 'settings') {
                Swal.fire({
                    icon: 'error',
                    text: '@lang("messages.settingModuleCannotBeDisabled")',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                })

                $(this).prop('checked', true);
                return false;
            }

        });

    </script>
@endpush
