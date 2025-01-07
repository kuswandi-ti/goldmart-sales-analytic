<div class="header-area" id="headerArea">
    <div class="container">
        <div
            class="header-content header-style-three position-relative d-flex align-items-center justify-content-between">
            <div class="navbar--toggler" id="affanNavbarToggler4" data-bs-toggle="offcanvas"
                data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                <div class="span-wrap">
                    <span class="d-block"></span>
                    <span class="d-block"></span>
                    <span class="d-block"></span>
                </div>
            </div>

            <div class="page-heading">
                <h6 class="mb-0">
                    @yield('section_header_title')
                </h6>
            </div>

            <div class="logo-wrapper">
                <a href="{{ route('dashboard.index') }}">
                    <img src="{{ url(config('common.path_template') . 'img/logo-goldmart.png') }}" alt="">
                </a>
            </div>
        </div>
    </div>
</div>
