<div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        <!-- Footer Content -->
        <div class="footer-nav position-relative shadow-sm footer-style-two">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                <li class="{{ setSidebarActive(['dashboard.*']) }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="bi bi-speedometer"></i>
                        @if (setSidebarActive(['dashboard.*']) == 'active')
                            <span></span>
                        @else
                            <span>{{ __('Dashboard') }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="pages.html">
                        <i class="bi bi-clipboard-data"></i>
                        <span>{{ __('Data') }}</span>
                    </a>
                </li>

                <li>
                    <a href="elements.html">
                        <i class="bi bi-grid"></i>
                        <span>{{ __('Input') }}</span>
                    </a>
                </li>

                <li>
                    <a href="chat-users.html">
                        <i class="bi bi-bell"></i>
                        <span>{{ __('Info') }}</span>
                    </a>
                </li>

                <li class="{{ setSidebarActive(['setting.*']) }}">
                    <a href="{{ route('setting.index') }}">
                        <i class="bi bi-gear"></i>
                        @if (setSidebarActive(['setting.*']) == 'active')
                            <span></span>
                        @else
                            <span>{{ __('Pengaturan') }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
