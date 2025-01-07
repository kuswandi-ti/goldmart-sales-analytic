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
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">{{ __('Loading...') }}</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    @yield('content')

    <!-- All JavaScript Files -->
    @include('layouts.partials._scripts')
</body>

</html>
