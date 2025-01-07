{{-- <!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark" style="--primary-rgb: 0, 128, 172;">

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
    <link rel="icon"
        href="{{ !empty($setting_system['company_logo']) ? url(config('common.path_storage') . $setting_system['company_logo']) : url(config('common.path_template') . config('common.logo_company_main')) }}"
        type="image/png">

    @include('layouts.partials._styles')

    <!-- Page Specific CSS File -->
    @stack('styles_vendor')

    <!-- Page Specific CSS Style -->
    @stack('styles')
</head>

<body>
    @include('layouts.partials._switcher')

    <!-- Loader -->
    <div id="loader">
        <img src="{{ url(config('common.path_template') . 'assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
        @include('layouts.partials._header')

        @include('layouts.partials._sidebar')

        <!-- Page Header -->
        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="mb-0 fw-medium">
                @yield('section_header_title')
            </h4>
            <ol class="breadcrumb">
                @section('section_header_breadcrumb')
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-white-50">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                @show
            </ol>
        </div>
        <!-- Page Header Close -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                @yield('page_content')
            </div>
        </div>
        <!-- End::app-content -->

        @include('layouts.partials._footer')
    </div>

    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-circle-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>

    @include('layouts.partials._scripts')

    <!-- Page Specific JS File -->
    @stack('scripts_vendor')

    <!-- Page Specific JS Script -->
    @stack('scripts')

    <!-- Inline JS -->
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
            $('body').on('keyup', '.number-only', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

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
            })

            $('body').on('click', '.approve', function(e) {
                e.preventDefault();
                swalWithBootstrapButtons.fire({
                    title: "{{ __('Anda yakin akan menyetujui ?') }}",
                    text: "{{ __('Setelah data terproses, status akan berubah menjadi approve') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Ya, setujui !') }}",
                    cancelButtonText: "{{ __('Batal') }}",
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $(this).attr('href');
                        $.ajax({
                            method: 'POST',
                            url: url,
                            success: function(data) {
                                if (data.status == 'success') {
                                    Swal.fire(
                                        "{{ __('Disetujui !') }}",
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
            })

            $('body').on('click', '.reject', function(e) {
                e.preventDefault();
                swalWithBootstrapButtons.fire({
                    title: "{{ __('Anda yakin akan menolak ?') }}",
                    text: "{{ __('Setelah data terproses, status akan berubah menjadi reject') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Ya, tolak !') }}",
                    cancelButtonText: "{{ __('Batal') }}",
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $(this).attr('href');
                        $.ajax({
                            method: 'POST',
                            url: url,
                            success: function(data) {
                                if (data.status == 'success') {
                                    Swal.fire(
                                        "{{ __('Ditolak !') }}",
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
            })

            $('body').on('click', '.deactivate', function(e) {
                e.preventDefault();
                swalWithBootstrapButtons.fire({
                    title: "{{ __('Anda yakin akan menonaktifkan data ?') }}",
                    text: "{{ __('Setelah data non aktif, data tidak bisa digunakan') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Ya, nonaktifkan data !') }}",
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
                                        "{{ __('Tidak Aktif !') }}",
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
            })
        });
    </script>
</body>

</html> --}}

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
    <link rel="apple-touch-icon" href="{{ url(config('common.path_template') . 'img/icons/icon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ url(config('common.path_template') . 'img/icons/icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167"
        href="{{ url(config('common.path_template') . 'img/icons/icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ url(config('common.path_template') . 'img/icons/icon-180x180.png') }}">

    <!-- Style CSS -->
    @include('layouts.partials._styles')

    <!-- Web App Manifest -->
    @include('layouts.partials._manifest')
</head>

<body>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container">
            <!-- Header Content -->
            <div
                class="header-content header-style-three position-relative d-flex align-items-center justify-content-between">
                <!-- Navbar Toggler -->
                <div class="navbar--toggler" id="affanNavbarToggler4" data-bs-toggle="offcanvas"
                    data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                    <div class="span-wrap">
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                    </div>
                </div>

                <!-- Logo Wrapper -->
                <div class="logo-wrapper">
                    <a href="{{ route('dashboard.index') }}">
                        <img src="{{ url(config('common.path_template') . 'img/logo-goldmart.png') }}" alt="">
                    </a>
                </div>

                <!-- User Profile -->
                <div class="user-profile-wrapper">
                    <a class="user-profile-trigger-btn" href="#">
                        <img src="{{ !empty(auth()->user()->image) ? url(config('common.path_storage') . auth()->user()->image) : url(config('common.path_template') . config('common.image_user_profile_small')) }}"
                            alt=""></a>
                </div>
            </div>
        </div>
    </div>

    <!-- # Sidenav Left -->
    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
        aria-labelledby="affanOffcanvsLabel">

        <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>

        <div class="offcanvas-body p-0">
            <div class="sidenav-wrapper">
                <!-- Sidenav Profile -->
                <div class="sidenav-profile bg-gradient">
                    <div class="sidenav-style1"></div>

                    <!-- User Thumbnail -->
                    <div class="user-profile">
                        <img src="img/bg-img/2.jpg" alt="">
                    </div>

                    <!-- User Info -->
                    <div class="user-info">
                        <h6 class="user-name mb-0">Affan Islam</h6>
                        <span>CEO, Designing World</span>
                    </div>
                </div>

                <!-- Sidenav Nav -->
                <ul class="sidenav-nav ps-0">
                    <li>
                        <a href="home.html"><i class="bi bi-house-door"></i> Home</a>
                    </li>
                    <li>
                        <a href="elements.html"><i class="bi bi-heart"></i> Elements
                            <span class="badge bg-danger rounded-pill ms-2">220+</span>
                        </a>
                    </li>
                    <li>
                        <a href="pages.html"><i class="bi bi-folder2-open"></i> Pages
                            <span class="badge bg-success rounded-pill ms-2">100+</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="bi bi-cart-check"></i> Shop</a>
                        <ul>
                            <li>
                                <a href="shop-grid.html"> Shop Grid</a>
                            </li>
                            <li>
                                <a href="shop-list.html"> Shop List</a>
                            </li>
                            <li>
                                <a href="shop-details.html"> Shop Details</a>
                            </li>
                            <li>
                                <a href="cart.html"> Cart</a>
                            </li>
                            <li>
                                <a href="checkout.html"> Checkout</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="settings.html"><i class="bi bi-gear"></i> Settings</a>
                    </li>
                    <li>
                        <div class="night-mode-nav">
                            <i class="bi bi-moon"></i> Night Mode
                            <div class="form-check form-switch">
                                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="logout" href="#">
                            <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
                        </a>
                        <form action="{{ route('logout') }}" method="post" id="form-logout">
                            @csrf
                        </form>
                    </li>
                </ul>

                <!-- Social Info -->
                <div class="social-info-wrap">
                    <a href="#">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>

                <!-- Copyright Info -->
                <div class="copyright-info">
                    <p>
                        <span id="copyrightYear"></span>
                        &copy; Made by <a href="#"> Designing World</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper">
        <!-- Tiny Slider One Wrapper -->
        <div class="tiny-slider-one-wrapper">
            <div class="tiny-slider-one">
                <!-- Single Hero Slide -->
                <div>
                    <div class="single-hero-slide bg-overlay" style="background-image: url('img/bg-img/31.jpg')">
                        <div class="h-100 d-flex align-items-center text-center">
                            <div class="container">
                                <h3 class="text-white mb-1">Build with Bootstrap 5</h3>
                                <p class="text-white mb-4">Build fast, responsive sites with Bootstrap.</p>
                                <a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Hero Slide -->
                <div>
                    <div class="single-hero-slide bg-overlay" style="background-image: url('img/bg-img/33.jpg')">
                        <div class="h-100 d-flex align-items-center text-center">
                            <div class="container">
                                <h3 class="text-white mb-1">Vanilla JavaScript</h3>
                                <p class="text-white mb-4">The whole code is written with vanilla JS.</p>
                                <a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Hero Slide -->
                <div>
                    <div class="single-hero-slide bg-overlay" style="background-image: url('img/bg-img/32.jpg')">
                        <div class="h-100 d-flex align-items-center text-center">
                            <div class="container">
                                <h3 class="text-white mb-1">PWA Ready</h3>
                                <p class="text-white mb-4">Click the "Install Now" button &amp; <br> enjoy it like an
                                    app.</p>
                                <a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Hero Slide -->
                <div>
                    <div class="single-hero-slide bg-overlay" style="background-image: url('img/bg-img/33.jpg')">
                        <div class="h-100 d-flex align-items-center text-center">
                            <div class="container">
                                <h3 class="text-white mb-1">Lots of Elements &amp; Pages</h3>
                                <p class="text-white mb-4">Create your website in days, not months.</p>
                                <a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Hero Slide -->
                <div>
                    <div class="single-hero-slide bg-overlay" style="background-image: url('img/bg-img/1.jpg')">
                        <div class="h-100 d-flex align-items-center text-center">
                            <div class="container">
                                <h3 class="text-white mb-1">Dark &amp; RTL Ready</h3>
                                <p class="text-white mb-4">You can use the Dark or <br> RTL mode of your choice.</p>
                                <a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-3"></div>

        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/pwa.png" alt="">
                                </div>
                                <p class="mb-0">PWA Ready</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/bootstrap.png" alt="">
                                </div>
                                <p class="mb-0">Bootstrap 5</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/js.png" alt="">
                                </div>
                                <p class="mb-0">Vanilla JS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card card-bg-img bg-img bg-overlay mb-3" style="background-image: url('img/bg-img/3.jpg')">
                <div class="card-body direction-rtl p-4">
                    <h2 class="text-white">220+ Reusable Elements</h2>
                    <p class="mb-3 text-white">More than 220+ reusable modern design elements. Just copy the code and
                        paste it on
                        your desired page.</p>
                    <a class="btn btn-warning" href="elements.html">All elements <i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/sass.png" alt="">
                                </div>
                                <p class="mb-0">SCSS</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/npm.png" alt="">
                                </div>
                                <p class="mb-0">npm</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/gulp.png" alt="">
                                </div>
                                <p class="mb-0">Gulp 4</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card bg-primary mb-3 bg-img" style="background-image: url('img/core-img/1.png')">
                <div class="card-body direction-rtl p-4">
                    <h2 class="text-white">35+ Ready Pages</h2>
                    <p class="mb-3 text-white">Already designed more than 35+ pages for your needs. Such as -
                        Authentication,
                        Chats, eCommerce, Blog &amp; Miscellaneous pages.</p>
                    <a class="btn btn-warning" href="pages.html">All Pages <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/dark.png" alt="">
                                </div>
                                <p class="mb-0">Dark Mode</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/rtl.png" alt="">
                                </div>
                                <p class="mb-0">RTL Ready</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/code.png" alt="">
                                </div>
                                <p class="mb-0">Easy Code</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card mb-3">
                <div class="card-body">
                    <h3>Customer Review</h3>

                    <div class="testimonial-slide-three-wrapper">
                        <div class="testimonial-slide3 testimonial-style3">

                            <!-- Single Testimonial Slide -->
                            <div class="single-testimonial-slide">
                                <div class="text-content">
                                    <span class="d-inline-block badge bg-warning mb-2">
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                    <h6 class="mb-2">The code looks clean, and the designs are excellent. I
                                        recommend.</h6>
                                    <span class="d-block">Mrrickez, Themeforest</span>
                                </div>
                            </div>

                            <!-- Single Testimonial Slide -->
                            <div class="single-testimonial-slide">
                                <div class="text-content">
                                    <span class="d-inline-block badge bg-warning mb-2">
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                    <h6 class="mb-2">All complete, <br> great craft.</h6>
                                    <span class="d-block">Mazatlumm, Themeforest</span>
                                </div>
                            </div>

                            <!-- Single Testimonial Slide -->
                            <div class="single-testimonial-slide">
                                <div class="text-content">
                                    <span class="d-inline-block badge bg-warning mb-2">
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                    <h6 class="mb-2">Awesome template! <br> Excellent support!</h6>
                                    <span class="d-block">Vguntars, Themeforest</span>
                                </div>
                            </div>

                            <!-- Single Testimonial Slide -->
                            <div class="single-testimonial-slide">
                                <div class="text-content">
                                    <span class="d-inline-block badge bg-warning mb-2">
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                    <h6 class="mb-2">Nice modern design, <br> I love the product.</h6>
                                    <span class="d-block">electroMEZ, Themeforest</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container direction-rtl">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/star.png" alt="">
                                </div>
                                <p class="mb-0">Best Rated</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/elegant.png" alt="">
                                </div>
                                <p class="mb-0">Elegant</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="img/demo-img/lightning.png" alt="">
                                </div>
                                <p class="mb-0">Trendsetter</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-3"></div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            <!-- Footer Content -->
            <div class="footer-nav position-relative shadow-sm footer-style-two">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li>
                        <a href="home.html">
                            <i class="bi bi-house"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li>
                        <a href="pages.html">
                            <i class="bi bi-folder2-open"></i>
                            <span>Pages</span>
                        </a>
                    </li>

                    <li class="active">
                        <a href="elements.html">
                            <i class="bi bi-heart"></i>
                        </a>
                    </li>

                    <li>
                        <a href="chat-users.html">
                            <i class="bi bi-chat-dots"></i>
                            <span>Chat</span>
                        </a>
                    </li>

                    <li>
                        <a href="settings.html">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- All JavaScript Files -->
    @include('layouts.partials._scripts')

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
