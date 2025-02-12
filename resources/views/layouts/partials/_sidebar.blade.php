<!-- Start::app-sidebar -->
<aside class="app-sidebar" id="sidebar">
    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('dashboard.index') }}" class="header-logo">
            {{-- <img src="{{ !empty($setting_system['company_logo_dekstop_2']) ? url(config('common.path_storage') . $setting_system['company_logo_desktop']) : url(config('common.path_template') . config('common.logo_company_desktop')) }}"
                alt="logo" class="desktop-logo" width="125" height="33">
            <img src="{{ !empty($setting_system['company_logo_toggle']) ? url(config('common.path_storage') . $setting_system['company_logo_toggle']) : url(config('common.path_template') . config('common.logo_company_toggle')) }}"
                alt="logo" class="toggle-logo" width="38" height="33">
            <img src="{{ !empty($setting_system['company_logo_desktop']) ? url(config('common.path_storage') . $setting_system['company_logo_desktop']) : url(config('common.path_template') . config('common.logo_company_desktop')) }}"
                alt="logo" class="desktop-dark" width="125" height="33">
            <img src="{{ !empty($setting_system['company_logo_toggle']) ? url(config('common.path_storage') . $setting_system['company_logo_toggle']) : url(config('common.path_template') . config('common.logo_company_toggle')) }}"
                alt="logo" class="toggle-dark" width="38" height="33"> --}}
            <img src="{{ !empty(url(config('common.path_template') . 'assets/images/logo-desktop.png')) ? url(config('common.path_template') . 'assets/images/logo-desktop.png') : url(config('common.path_template') . config('common.logo_company_desktop')) }}"
                alt="logo" class="desktop-logo" width="125" height="33">
            <img src="{{ !empty(url(config('common.path_template') . 'assets/images/logo-toggle.png')) ? url(config('common.path_template') . 'assets/images/logo-toggle.png') : url(config('common.path_template') . config('common.logo_company_toggle')) }}"
                alt="logo" class="toggle-logo" width="38" height="33">
            <img src="{{ !empty(url(config('common.path_template') . 'assets/images/logo-desktop.png')) ? url(config('common.path_template') . 'assets/images/logo-desktop.png') : url(config('common.path_template') . config('common.logo_company_desktop')) }}"
                alt="logo" class="desktop-dark" width="125" height="33">
            <img src="{{ !empty(url(config('common.path_template') . 'assets/images/logo-toggle.png')) ? url(config('common.path_template') . 'assets/images/logo-toggle.png') : url(config('common.path_template') . config('common.logo_company_toggle')) }}"
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
                <li class="mt-4 slide__category">
                    <span class="category-name badge bg-danger">
                        <strong>{{ getSession(5) }}</strong>
                    </span>
                    <span class="category-name badge bg-danger">
                        <strong>{{ getSession(6) }}</strong>
                    </span>
                </li>

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
                @if (canAccess([
                        'kota index',
                        'store index',
                        'sales person index',
                        'brand index',
                        'tipe barang index',
                        'range harga index',
                        'customer visit index',
                        'customer visit create',
                    ]))
                    <li class="mt-4 slide__category"><span class="category-name">{{ __('Data') }}</span></li>
                @endif
                <!-- End::slide__category -->

                <!-- Start::slide -->
                @if (canAccess(['kota index']))
                    <li class="slide {{ setSidebarActive(['kotas.*']) }}">
                        <a href="{{ route('kotas.index') }}"
                            class="side-menu__item {{ setSidebarActive(['kotas.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-map-alt'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Kota') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['store index']))
                    <li class="slide {{ setSidebarActive(['store.*']) }}">
                        <a href="{{ route('store.index') }}"
                            class="side-menu__item {{ setSidebarActive(['store.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-store'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Store') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['sales person index']))
                    <li class="slide {{ setSidebarActive(['salesperson.*']) }}">
                        <a href="{{ route('salesperson.index') }}"
                            class="side-menu__item {{ setSidebarActive(['salesperson.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-user-voice'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Sales Person') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['brand index']))
                    <li class="slide {{ setSidebarActive(['brand.*']) }}">
                        <a href="{{ route('brand.index') }}"
                            class="side-menu__item {{ setSidebarActive(['brand.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxl-microsoft'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Brand') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['tipe barang index']))
                    <li class="slide {{ setSidebarActive(['tipebarang.*']) }}">
                        <a href="{{ route('tipebarang.index') }}"
                            class="side-menu__item {{ setSidebarActive(['tipebarang.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-diamond'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Tipe Barang') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['range harga index']))
                    <li class="slide {{ setSidebarActive(['rangeharga.*']) }}">
                        <a href="{{ route('rangeharga.index') }}"
                            class="side-menu__item {{ setSidebarActive(['rangeharga.*']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bx-collapse-horizontal'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Range Harga') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['customer visit index', 'customer visit create']))
                    <li
                        class="slide has-sub {{ setSidebarActive(['customervisit.*']) }} {{ setSidebarOpen(['customervisit.*']) }}">
                        <a href="javascript:void(0);"
                            class="side-menu__item {{ setSidebarActive(['customervisit.*']) }}">
                            <span class=" side-menu__icon">
                                <i class='bx bx-category'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Customer Visit') }}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul
                            class="slide-menu child1 {{ setSidebarActive(['customervisit.index.*', 'customervisit.create.*']) }}">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">{{ __('Customer Visit') }}</a>
                            </li>
                            @if (canAccess(['customer visit index']))
                                <li class="slide {{ setSidebarActive(['customervisit.index.*']) }}">
                                    <a href="{{ route('customervisit.index') }}"
                                        class="side-menu__item {{ setSidebarActive(['customervisit.index']) }}">
                                        {{ __('List Data') }}
                                    </a>
                                </li>
                            @endif
                            @if (canAccess(['customer visit create']))
                                <li class="slide {{ setSidebarActive(['customervisit.create.*']) }}">
                                    <a href="{{ route('customervisit.create') }}"
                                        class="side-menu__item {{ setSidebarActive(['customervisit.create']) }}">
                                        {{ __('Input Data') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                <!-- End::slide -->
                {{-- ======================================================================================================= --}}
                {{-- INPUT DATA - END --}}
                {{-- ======================================================================================================= --}}

                {{-- ======================================================================================================= --}}
                {{-- LAPORAN - BEGIN --}}
                {{-- ======================================================================================================= --}}
                <!-- Start::slide__category -->
                @if (canAccess([
                        'laporan penjualan per person',
                        'laporan penjualan per store',
                        'laporan penjualan all store',
                        'laporan kunjungan per person',
                        'laporan kunjungan per store',
                        'laporan kunjungan detail',
                    ]))
                    <li class="mt-4 slide__category"><span class="category-name">{{ __('Laporan') }}</span>
                    </li>
                @endif
                <!-- End::slide__category -->

                <!-- Start::slide -->
                @if (canAccess(['laporan penjualan per person', 'laporan penjualan per store']))
                    <li
                        class="slide has-sub {{ setSidebarActive(['laporan.penjualan*']) }} {{ setSidebarOpen(['laporan.penjualan*']) }}">
                        <a href="javascript:void(0);"
                            class="side-menu__item {{ setSidebarActive(['laporan.penjualan*']) }}">
                            <span class=" side-menu__icon">
                                <i class='bx bx-file'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Laporan Penjualan') }}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul
                            class="slide-menu child1 {{ setSidebarActive(['laporan.penjualanperperson.*', 'laporan.penjualanperstore.*']) }}">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">{{ __('Laporan Penjualan') }}</a>
                            </li>
                            @if (canAccess(['laporan penjualan per person']))
                                <li class="slide {{ setSidebarActive(['laporan.penjualanperperson']) }}">
                                    <a href="{{ route('laporan.penjualanperperson') }}"
                                        class="side-menu__item {{ setSidebarActive(['laporan.penjualanperperson']) }}">
                                        <span class="side-menu__label">{{ __('Penjualan Per Person') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (canAccess(['laporan penjualan per store']))
                                <li class="slide {{ setSidebarActive(['laporan.penjualanperstore']) }}">
                                    <a href="{{ route('laporan.penjualanperstore') }}"
                                        class="side-menu__item {{ setSidebarActive(['laporan.penjualanperstore']) }}">
                                        <span class="side-menu__label">{{ __('Penjualan Per Store') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (canAccess(['laporan kunjungan per person', 'laporan kunjungan per store', 'laporan kunjungan detail']))
                    <li
                        class="slide has-sub {{ setSidebarActive(['laporan.kunjungan*']) }} {{ setSidebarOpen(['laporan.kunjungan*']) }}">
                        <a href="javascript:void(0);"
                            class="side-menu__item {{ setSidebarActive(['laporan.kunjungan*']) }}">
                            <span class=" side-menu__icon">
                                <i class='bx bx-file'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Laporan Kunjungan') }}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul
                            class="slide-menu child1 {{ setSidebarActive(['laporan.kunjunganperperson.*', 'laporan.kunjunganperstore.*', 'laporan.kunjungandetail.*']) }}">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">{{ __('Laporan Kunjungan') }}</a>
                            </li>
                            @if (canAccess(['laporan kunjungan per person']))
                                <li class="slide {{ setSidebarActive(['laporan.kunjunganperperson']) }}">
                                    <a href="{{ route('laporan.kunjunganperperson') }}"
                                        class="side-menu__item {{ setSidebarActive(['laporan.kunjunganperperson']) }}">
                                        <span class="side-menu__label">{{ __('Kunjungan Per Person') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (canAccess(['laporan kunjungan per store']))
                                <li class="slide {{ setSidebarActive(['laporan.kunjunganperstore']) }}">
                                    <a href="{{ route('laporan.kunjunganperstore') }}"
                                        class="side-menu__item {{ setSidebarActive(['laporan.kunjunganperstore']) }}">
                                        <span class="side-menu__label">{{ __('Kunjungan Per Store') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (canAccess(['laporan kunjungan detail']))
                                <li class="slide {{ setSidebarActive(['laporan.kunjungandetail']) }}">
                                    <a href="{{ route('laporan.kunjungandetail') }}"
                                        class="side-menu__item {{ setSidebarActive(['laporan.kunjungandetail']) }}">
                                        <span class="side-menu__label">{{ __('Kunjungan Detail') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                <!-- End::slide -->

                <!-- Start::slide -->
                {{-- @if (canAccess(['laporan penjualan per person']))
                    <li class="slide {{ setSidebarActive(['laporan.penjualanperperson']) }}">
                        <a href="{{ route('laporan.penjualanperperson') }}"
                            class="side-menu__item {{ setSidebarActive(['laporan.penjualanperperson']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-report'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Penjualan Per Person') }}</span>
                        </a>
                    </li>
                @endif
                @if (canAccess(['laporan penjualan per store']))
                    <li class="slide {{ setSidebarActive(['laporan.penjualanperstore']) }}">
                        <a href="{{ route('laporan.penjualanperstore') }}"
                            class="side-menu__item {{ setSidebarActive(['laporan.penjualanperstore']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-report'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Penjualan Per Store') }}</span>
                        </a>
                    </li>
                @endif

                @if (canAccess(['laporan penjualan all store']))
                    <li class="slide {{ setSidebarActive(['laporan.penjualanallstore']) }}">
                        <a href="{{ route('laporan.penjualanallstore') }}"
                            class="side-menu__item {{ setSidebarActive(['laporan.penjualanallstore']) }}">
                            <span class="side-menu__icon">
                                <i class='bx bxs-report'></i>
                            </span>
                            <span class="side-menu__label">{{ __('Penjualan All Store') }}</span>
                        </a>
                    </li>
                @endif --}}
                <!-- End::slide -->
                {{-- ======================================================================================================= --}}
                {{-- LAPORAN - END --}}
                {{-- ======================================================================================================= --}}

                {{-- ======================================================================================================= --}}
                {{-- PENGATURAN - BEGIN --}}
                {{-- ======================================================================================================= --}}
                <!-- Start::slide__category -->
                @if (canAccess(['user index', 'role index', 'permission index', 'setting info perusahaan', 'setting lainnya']))
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
                @if (canAccess(['setting info perusahaan', 'setting lainnya']))
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
