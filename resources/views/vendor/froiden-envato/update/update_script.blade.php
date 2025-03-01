<script type="text/javascript">
    var updateAreaDiv = $('#update-area');
    var refreshPercent = 0;
    var checkInstall = true;

    $('#update-app').click(function () {
        if ($('#update-frame').length) {
            return false;
        }
        @php($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting())

        @if(!is_null($envatoUpdateCompanySetting->supported_until) && \Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->isPast())
        let supportText = " Your support has been expired on <b><span id='support-date'>{{\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->translatedFormat('dS M, Y')}}</span></b>";

        Swal.fire({
            title: "Support Expired",
            html: supportText + "<br>Please renew your support for one-click updates.<br><br> You can still update the application manually by following the documentation <a href='https://froiden.freshdesk.com/support/solutions/articles/43000554421-update-application-manually' target='_blank' class='underline underline-offset-1 ml-2 text-skin-base'>Update Application Manually</a>",
            showCancelButton: true,
            confirmButtonText: "Renew Now",
            denyButtonText: `Free Support Guidelines`,
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true,
            showCloseButton: true,
            icon: 'warning',
            focusConfirm: false,
            customClass: {
                confirmButton: 'text-white justify-center bg-skin-base hover:bg-skin-base/[.8] sm:w-auto dark:bg-skin-base dark:hover:bg-skin-base/[.8] font-semibold rounded-lg text-sm px-5 py-2.5 text-center',
                denyButton: 'ml-5 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg font-semibold text-sm text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150  mr-3 p-2',
                cancelButton: 'ml-5 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg font-semibold text-sm text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.open(
                    "{{ config('froiden_envato.envato_product_url') }}",
                    '_blank'
                );
            }
        });


        @else

        Swal.fire({

            title: "Are you sure?",
            html: `<x-alert type="danger" icon="info-circle">

<div>Please do not click the <strong>Yes! Update It</strong> button if the application has been customized. Your changes may be lost.\n
                <br>
                <br>
                <div>As a precautionary measure, please make a backup of your files and database before updating.. \</div>
                <br>
                <strong class="dark:text-white"><i>Please note that the author will not be held responsible for any loss of data or issues that may occur during the update process.</i></strong>
</div>
                </x-alert>
                <span class="text-base text-gray-900 dark:text-white">To confirm if you have read the above message, type <strong><i>confirm</i></strong> in the field.</span>
                `,
            icon: 'info',
            focusConfirm: true,
            customClass: {
                confirmButton: 'text-white justify-center bg-skin-base hover:bg-skin-base/[.8] sm:w-auto dark:bg-skin-base dark:hover:bg-skin-base/[.8] font-semibold rounded-lg text-sm px-5 py-2.5 text-center',
                cancelButton: 'ml-5 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg font-semibold text-sm text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false,
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: "Yes, update it!",
            cancelButtonText: "No, cancel please!",
            showLoaderOnConfirm: true,
            preConfirm: (isConfirm) => {

                if (!isConfirm) {
                    return false;
                }

                if (isConfirm.toLowerCase() !== "confirm") {

                    Swal.fire({
                        title: "Text not matched",
                        html: "You have entered wrong spelling of <b>confirm</b>",
                        icon: 'error',
                    });
                    return false;
                }
                if (isConfirm.toLowerCase() === "confirm") {
                    return true;
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                updateAreaDiv.removeClass('hidden');
                Swal.close();
                $.easyAjax({
                    type: 'GET',
                    blockUI: true,
                    url: '{!! route("admin.updateVersion.update") !!}',
                    success: function (response) {
                        if (response.status === 'success') {
                            updateAreaDiv.html("<strong>Downloading...:-</strong><br> ");
                            downloadScript();
                            downloadPercent();
                        } else if (response.status === 'fail')
                            updateAreaDiv.addClass('hidden');
                    }
                });
            }
        });
        @endif


    })

    function downloadScript() {
        $.easyAjax({
            type: 'GET',
            url: '{!! route("admin.updateVersion.download") !!}',
            success: function (response) {
                clearInterval(refreshPercent);

                if(response.status === 'fail'){
                    updateAreaDiv.html(`<i><span class='text-red-500'><strong>Update Failed</strong> :</span> ${response.message}</i>`)
                    return false;
                }

                $('#percent-complete').css('width', '100%');
                $('#percent-complete').html('100%');
                $('#download-progress').append("<i><span class='text-green-500'>Download complete.</span> Now Installing...Please wait (This may take few minutes.)</i>");

                window.setInterval(function () {
                    /// call your function here
                    if (checkInstall == true) {
                        checkIfFileExtracted();
                    }
                }, 1500);

                installScript();

            }
        });
    }

    function getDownloadPercent() {
        $.easyAjax({
            type: 'GET',
            url: '{!! route("admin.updateVersion.downloadPercent") !!}',
            success: function (response) {
                response = response.toFixed(1);
                $('#percent-complete').css('width', response + '%');
                $('#percent-complete').html(response + '%');
            }
        });
    }

    function checkIfFileExtracted() {
        $.easyAjax({
            type: 'GET',
            url: '{!! route("admin.updateVersion.checkIfFileExtracted") !!}',
            success: function (response) {
                checkInstall = false;
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        });
    }

    function downloadPercent() {
        updateAreaDiv.append(`<div id="download-progress" class="text-sm font-semibold border-b mb-2 ">
                    <div class="mb-1">Download Progress...</div>
                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 mb-3 ">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" id="percent-complete" style="width: 0%"> 0%</div>
                    </div>
                </div>`);
        //getting data
        refreshPercent = window.setInterval(function () {
            getDownloadPercent();
            /// call your function here
        }, 1500);
    }

    function installScript() {
        $.easyAjax({
            type: 'GET',
            url: '{!! route("admin.updateVersion.install") !!}',
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        });
    }

    function getPurchaseData() {
        var token = "{{ csrf_token() }}";
        $.easyAjax({
            type: 'POST',
            url: "{{ route('purchase-verified') }}",
            data: {'_token': token},
            container: "#support-div",
            messagePosition: 'inline',
            success: function (response) {
                window.location.reload();
            }
        });
        return false;
    }
</script>
