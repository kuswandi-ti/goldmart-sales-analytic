<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close" style="--primary-rgb: 0, 128, 172;">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ $setting_system['site_title'] ?? config('app.name') }} &mdash; @yield('page_title')</title>

    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="simple admin panel template html css,admin panel html,bootstrap 5 admin template,admin,bootstrap dashboard,bootstrap 5 admin panel template,html and css,admin panel,admin panel html template,simple html template,bootstrap admin template,admin dashboard,admin dashboard template,admin panel template,template dashboard">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    {{-- <link rel="icon"
        href="{{ !empty($setting_system['company_logo']) ? url(config('common.path_storage') . $setting_system['company_logo']) : url(config('common.path_template') . config('common.logo_company_main')) }}"
        type="image/png"> --}}
    <link rel="icon"
        href="{{ !empty(url(config('common.path_template') . 'assets/images/logo-square.jpg')) ? url(config('common.path_template') . 'assets/images/logo-square.jpg') : url(config('common.path_template') . config('common.logo_company_main')) }}"
        type="image/png">

    <!-- Main Theme Js -->
    <script src="{{ url(config('common.path_template') . 'assets/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style"
        href="{{ url(config('common.path_template') . 'assets/libs/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ url(config('common.path_template') . 'assets/css/styles.min.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ url(config('common.path_template') . 'assets/css/icons.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="page error-bg" id="particles-js">
        <div class="error-page ">
            <div class="container">
                <div class="row justify-content-center">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ url(config('common.path_template') . 'assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Show Password JS -->
    <script src="{{ url(config('common.path_template') . 'assets/js/show-password.js') }}"></script>
</body>

</html>
