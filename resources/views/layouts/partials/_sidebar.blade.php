<!-- Start::app-sidebar -->
<aside class="app-sidebar" id="sidebar">
    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('dashboard.index') }}" class="header-logo">
            <img src="{{ !empty($setting_system['company_logo_dekstop']) ? url(config('common.path_storage') . $setting_system['company_logo_desktop']) : url(config('common.path_template') . config('common.logo_company_desktop')) }}"
                alt="logo" class="desktop-logo" width="125" height="33">
            <img src="{{ !empty($setting_system['company_logo_toggle']) ? url(config('common.path_storage') . $setting_system['company_logo_toggle']) : url(config('common.path_template') . config('common.logo_company_toggle')) }}"
                alt="logo" class="toggle-logo" width="38" height="33">
            <img src="{{ !empty($setting_system['company_logo_desktop']) ? url(config('common.path_storage') . $setting_system['company_logo_desktop']) : url(config('common.path_template') . config('common.logo_company_desktop')) }}"
                alt="logo" class="desktop-dark" width="125" height="33">
            <img src="{{ !empty($setting_system['company_logo_toggle']) ? url(config('common.path_storage') . $setting_system['company_logo_toggle']) : url(config('common.path_template') . config('common.logo_company_toggle')) }}"
                alt="logo" class="toggle-dark" width="38" height="33">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">
        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                {{-- ======================================================================================================= --}}
                {{-- DASHBOARD - BEGIN --}}
                {{-- ======================================================================================================= --}}
                <!-- Start::slide__category -->
                <li class="mt-4 slide__category"><span class="category-name">{{ __('Dashboard') }}</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('dashboard.index') }}"
                        class="side-menu__item {{ setSidebarActive(['dashboard.*']) }}">
                        <span class=" side-menu__icon">
                            <i class='bx bx-desktop'></i>
                        </span>
                        <span class="side-menu__label">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <!-- End::slide -->
                {{-- ======================================================================================================= --}}
                {{-- DASHBOARD - END --}}
                {{-- ======================================================================================================= --}}


                {{-- ======================================================================================================= --}}
                {{-- INPUT DATA - BEGIN --}}
                {{-- ======================================================================================================= --}}
                <!-- Start::slide__category -->
                @if (canAccess(['nasabah index', 'kredit nasabah index']))
                    <li class="mt-4 slide__category"><span class="category-name">{{ __('Data') }}</span></li>
                @endif
                <!-- End::slide__category -->

                <!-- Start::slide -->
                @if (canAccess(['nasabah index']))
                    <li class="slide {{ setSidebarActive(['nasabah.*']) }}">
                        <a href="{{ route('nasabah.index') }}"
                            class="side-menu__item {{ setSidebarActive(['nasabah.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-donate-heart'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Nasabah') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['kredit nasabah index']))
                    <li class="slide {{ setSidebarActive(['kreditnasabah.*']) }}">
                        <a href="{{ route('kreditnasabah.index') }}"
                            class="side-menu__item {{ setSidebarActive(['kreditnasabah.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-credit-card'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Kredit Nasabah') }}</span>
                        </a>
                    </li>
                @endif
                <!-- End::slide -->
                {{-- ======================================================================================================= --}}
                {{-- INPUT DATA - END --}}
                {{-- ======================================================================================================= --}}

                {{-- ======================================================================================================= --}}
                {{-- PENGATURAN - BEGIN --}}
                {{-- ======================================================================================================= --}}
                <!-- Start::slide__category -->
                @if (canAccess(['user index', 'role index', 'permission index', 'setting system']))
                    <li class="mt-4 slide__category"><span class="category-name">{{ __('Pengaturan') }}</span>
                    </li>
                @endif
                <!-- End::slide__category -->

                <!-- Start::slide -->
                @if (canAccess(['user index']))
                    <li class="slide {{ setSidebarActive(['user.*']) }}">
                        <a href="{{ route('user.index') }}"
                            class="side-menu__item {{ setSidebarActive(['user.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bx-user'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Manajemen User') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['role index', 'permission index']))
                    <li
                        class="slide has-sub {{ setSidebarActive(['permission.*', 'role.*']) }} {{ setSidebarOpen(['permission.*', 'role.*']) }}">
                        <a href="javascript:void(0);"
                            class="side-menu__item {{ setSidebarActive(['permission.*', 'role.*']) }}">
                            <span class=" side-menu__icon">
                                <i class='bx bxs-lock-open-alt'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Roles & Permissions') }}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 {{ setSidebarActive(['permission.*', 'role.*']) }}">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">{{ __('Roles & Permissions') }}</a>
                            </li>
                            @if (canAccess(['role index']))
                                <li class="slide {{ setSidebarActive(['role.*']) }}">
                                    <a href="{{ route('role.index') }}"
                                        class="side-menu__item {{ setSidebarActive(['role.*']) }}">
                                        {{ __('Roles') }}
                                    </a>
                                </li>
                            @endif
                            @if (canAccess(['permission index']))
                                <li class="slide {{ setSidebarActive(['permission.*']) }}">
                                    <a href="{{ route('permission.index') }}"
                                        class="side-menu__item {{ setSidebarActive(['permission.*']) }}">
                                        {{ __('Permissions') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (canAccess(['setting system']))
                    <li class="slide {{ setSidebarActive(['setting.*']) }}">
                        <a href="{{ route('setting.index') }}"
                            class="side-menu__item {{ setSidebarActive(['setting.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bx-cog'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Pengaturan Sistem') }}</span>
                        </a>
                    </li>
                @endif
                <!-- End::slide -->
                {{-- ======================================================================================================= --}}
                {{-- PENGATURAN - END --}}
                {{-- ======================================================================================================= --}}
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                    </path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
