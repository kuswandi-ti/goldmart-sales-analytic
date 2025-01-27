<!-- app-header -->
<header class="app-header">
    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">
        <!-- Start::header-content-left -->
        <div class="header-content-left">
            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="anchor" href="javascript:void(0);" class="sidemenu-toggle header-link"
                    data-bs-toggle="sidebar">
                    <span class="open-toggle me-2">
                        <i class="bx bx-menu header-link-icon"></i>
                    </span>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

            <a aria-label="anchor" href="javascript:void(0);" class="header-link dropdown-toggle"
                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                {{-- <span class="text-light">{{ __('Periode Aktif') }}</span>
                <span class="text-light">&nbsp; : &nbsp;</span> --}}
                <span class="text-dark">{{ __('Periode Aktif') }}</span>
                <span class="text-dark">&nbsp; : &nbsp;</span>
                <span class="badge bg-danger pulse pulse-secondary"><strong>{{ activePeriod() }}</strong></span>
            </a>
            @can('setting lainnya')
                <form method="POST" action="{{ route('other_setting.update') }}">
                    @csrf
                    @method('PUT')
                    <ul class="main-header-dropdown dropdown-menu border-0" data-popper-placement="none">
                        <li>
                            <a class="dropdown-item d-flex align-items-center">
                                <input type="text"
                                    class="form-control me-2 number-only default-number @error('tahun_periode_aktif') is-invalid @enderror"
                                    name="tahun_periode_aktif" id="tahun_periode_aktif"
                                    value="{{ old('tahun_periode_aktif') ?? (!empty(activePeriod()) ? activePeriod() : '0') }}"
                                    placeholder="{{ __('Tahun Periode Aktif') }}" aria-describedby="basic-addon2"
                                    size="4" required>
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Update') }}
                                </button>
                                @error('tahun_periode_aktif')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </a>
                        </li>
                    </ul>
                </form>
            @endcan
        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <div class="header-content-right">
            <!-- Start::header-element -->
            @can('customer visit create')
                <div class="header-element">
                    <!-- Start::header-link|layout-setting -->
                    <a aria-label="anchor" href="{{ route('customervisit.create') }}" class="header-link">
                        <!-- Start::header-link-icon -->
                        <i class="bx bx-category header-link-icon ionicon"></i>
                        <!-- End::header-link-icon -->
                    </a>
                    <!-- End::header-link|layout-setting -->
                </div>
            @endcan
            {{-- <div class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a aria-label="anchor" href="javascript:void(0);" class="header-link layout-setting">
                    <!-- Start::header-link-icon -->
                    <i class="bx bx-sun bx-flip-horizontal header-link-icon ionicon dark-layout"></i>
                    <!-- End::header-link-icon -->
                    <!--  Start::header-link-icon -->
                    <i class="bx bx-moon bx-flip-horizontal header-link-icon ionicon light-layout"></i>
                    <!-- End::header-link-icon -->
                </a>
                <!-- End::header-link|layout-setting -->
            </div> --}}
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element mainuserProfile">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="d-sm-flex wd-100p">
                            <div class="avatar avatar-sm">
                                <img alt="avatar" class="rounded-circle"
                                    src="{{ !empty(auth()->user()->image) ? url(config('common.path_storage') . auth()->user()->image) : url(config('common.path_template') . config('common.image_user_profile_small')) }}"
                                    width="28" height="28">
                            </div>
                            <div class="my-auto ms-2 d-none d-xl-flex">
                                {{-- <h6 class="mb-0 font-weight-semibold fs-13 user-name d-sm-block d-none">
                                    {{ auth()->user()->name }}</h6> --}}
                                <h6 class="mb-0 font-weight-semibold fs-13 user-name d-sm-block d-none text-dark">
                                    {{ auth()->user()->name }}</h6>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="overflow-hidden border-0 dropdown-menu main-header-dropdown header-profile-dropdown"
                    aria-labelledby="mainHeaderProfile">
                    <li>
                        <a class="dropdown-item border-bottom" href="{{ route('profile.index') }}">
                            <i class="fs-13 me-2 bx bx-user"></i>
                            {{ __('Profil') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item logout" href="#">
                            <i class="fs-13 me-2 bx bx-arrow-to-right"></i>
                            {{ __('Logout') }}
                        </a>
                        <form action="{{ route('logout') }}" method="post" id="form-logout">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            {{-- <div class="header-element">
                <!-- Start::header-link|switcher-icon -->
                <a aria-label="anchor" href="javascript:void(0);" class="header-link switcher-icon ms-1"
                    data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                    <i class="bx bx-cog bx-spin header-link-icon"></i>
                </a>
                <!-- End::header-link|switcher-icon -->
            </div> --}}
            <!-- End::header-element -->
        </div>
        <!-- End::header-content-right -->
    </div>
    <!-- End::main-header-container -->
</header>
<!-- /app-header -->
