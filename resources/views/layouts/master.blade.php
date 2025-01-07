<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Affan - PWA Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ $setting_system['site_title_2'] ?? config('app.name') }} &mdash; @yield('page_title')</title>

    <!-- Favicon -->
    <link rel="icon"
        href="{{ !empty($setting_system['company_logo']) ? url(config('common.path_storage') . $setting_system['company_logo']) : url(config('common.path_template') . config('common.logo_company_main')) }}"
        type="image/png">
    <link rel="apple-touch-icon"
        href="{{ !empty($setting_system['company_logo']) ? url(config('common.path_storage') . $setting_system['company_logo']) : url(config('common.path_template') . config('common.logo_company_main')) }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ !empty($setting_system['company_logo']) ? url(config('common.path_storage') . $setting_system['company_logo']) : url(config('common.path_template') . config('common.logo_company_main')) }}">
    <link rel="apple-touch-icon" sizes="167x167"
        href="{{ !empty($setting_system['company_logo']) ? url(config('common.path_storage') . $setting_system['company_logo']) : url(config('common.path_template') . config('common.logo_company_main')) }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ !empty($setting_system['company_logo']) ? url(config('common.path_storage') . $setting_system['company_logo']) : url(config('common.path_template') . config('common.logo_company_main')) }}">

    <!-- Style CSS -->
    @include('layouts.partials._styles')

    <!-- Web App Manifest -->
    @include('layouts.partials._manifest')
</head>

<body>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    @include('layouts.partials._header')

    @include('layouts.partials._sidebar')

    <div class="page-content-wrapper py-3">
        @yield('page_content')
    </div>

    @include('layouts.partials._footer')

    <!-- All JavaScript Files -->
    @include('layouts.partials._scripts')

    <!-- Page Specific JS File -->
    @stack('scripts_vendor')

    <!-- Page Specific JS Script -->
    @stack('scripts')

    <script>
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger ms-2',
                cancelButton: 'btn btn-success'
            },
            buttonsStyling: false
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function preview(target, image) {
            $(target)
                .attr('src', window.URL.createObjectURL(image))
                .show()
        }

        function truncateString(text, length = 10, prefix = '...') {
            return jQuery.trim(text).substring(0, length).trim(this) + prefix;
        }

        window.formatAmount = function(num, digit = 2) {
            var rounded = (Math.round(num * 100) / 100).toFixed(digit);
            return rounded.replace(/\d(?=(\d{3})+\.)/g, '$&,');
        };

        $(document).ready(function() {
            $('.custom-file-input').on('change', function() {
                let filename = $(this)
                    .val()
                    .split('\\')
                    .pop()
                $(this)
                    .next('.custom-file-label')
                    .addClass('selected')
                    .html(filename)
            })


            $('body').on('click', '.logout', function(e) {
                e.preventDefault();
                swalWithBootstrapButtons.fire({
                    title: "{{ __('Anda yakin akan logout ?') }}",
                    text: "{{ __('Setelah logout akan kembali ke halaman login') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Ya, logout !') }}",
                    cancelButtonText: "{{ __('Batal') }}",
                    reverseButtons: false
                }).then((result) => {
                    if (result.value === true) {
                        $('#form-logout').submit()
                    }
                })
            })

            $('body').on('click', '.delete_item', function(e) {
                e.preventDefault();
                swalWithBootstrapButtons.fire({
                    title: "{{ __('Anda yakin akan menghapus data ?') }}",
                    text: "{{ __('Setelah data terhapus, anda tidak dapat mengembalikannya') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Ya, hapus data !') }}",
                    cancelButtonText: "{{ __('Batal') }}",
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $(this).attr('href');
                        $.ajax({
                            method: 'DELETE',
                            url: url,
                            success: function(data) {
                                if (data.status == 'success') {
                                    Swal.fire(
                                        "{{ __('Terhapus !') }}",
                                        data.message,
                                        'success'
                                    ).then(() => {
                                        window.location.reload();
                                    });
                                } else if (data.status == 'error') {
                                    Swal.fire(
                                        'Error!',
                                        data.message,
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                })
            });
        });
    </script>

</body>

</html>
