@extends('layouts.auth')

@section('page_title')
    {{ __('Login') }}
@endsection

@section('content')
    <div class="col-xl-8 col-md-12 col-sm-10 ">
        <div class="card custom-card rectangle2">
            <div class="p-0 card-body ">
                <div class="row">
                    <div class="col-xl-6 col-md-6 ps-0 text-fixed-white rounded-0 d-none d-md-block ">
                        <div class="mb-0 overflow-hidden card custom-card cover-background rounded-start rounded-0">
                            <div class="p-0 card-img-overlay d-flex align-items-center rounded-0">
                                <div class="p-5 card-body rectangle3">
                                    <div class="text-center">
                                        {{-- <img src="{{ !empty($setting_system['company_logo']) ? url(config('common.path_storage') . $setting_system['company_logo']) : url(config('common.path_template') . config('common.logo_company_main')) }}"
                                            alt="logo" class="desktop-dark img-fluid rounded" width="200"
                                            height="200"> --}}
                                        <img src="{{ !empty(url(config('common.path_template') . 'assets/images/logo-square.jpg')) ? url(config('common.path_template') . 'assets/images/logo-square.jpg') : url(config('common.path_template') . config('common.logo_company_main')) }}"
                                            alt="logo" class="desktop-dark img-fluid rounded" width="200"
                                            height="200">
                                    </div>
                                    <div class="mt-3 d-flex">
                                        <p class="mb-0 fw-normal fs-14 op-7 text-fixed-white text-center">
                                            {{ __('Selamat datang kembali di ') }}
                                            <strong>{{ $setting_system['site_title'] ?? config('app.name') }}</strong><br><br>
                                            {{ __('Masukkan email dan password akun anda agar bisa menggunakan fasilitas-fasilitas menu yang ada di sistem') }}
                                            <strong>{{ $setting_system['site_title'] ?? config('app.name') }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 pe-sm-0">
                        <div class="text-center">
                            <img src="{{ url(config('common.path_template') . 'assets/images/sales-illustration.webp') }}"
                                alt="logo" class="desktop-dark img-fluid rounded mb-2 mt-4" width="250">
                            <p class="fw-semibold">
                                {{ $setting_system['site_title'] ?? config('app.name') }}
                            </p>
                        </div>

                        <div class="p-sm-5">
                            <p class="mb-2 h4 fw-semibold">
                                {{ __('Login') }}
                            </p>

                            <p class="mb-4 text-muted op-7 fw-normal">
                                {{ __('Selamat datang di sistem kami') }}
                            </p>

                            <x-web-alert-message />

                            <form method="POST" action="{{ route('login.post') }}">
                                @csrf

                                <div class="mt-3 row gy-3">
                                    <div class="mt-0 col-xl-12">
                                        <label for="email" class="form-label text-default">
                                            {{ __('Email / NIK') }} <x-all-not-null />
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            name="email" id="email" value="{{ old('email') }}"
                                            placeholder="{{ __('Email / NIK') }}" required autofocus>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-xl-12">
                                        <label for="password" class="form-label text-default d-block">
                                            {{ __('Password') }} <x-all-not-null />
                                            <a href="{{ route('forgot_password') }}" class="float-end text-primary">
                                                {{ __('Lupa password ?') }}
                                            </a>
                                        </label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                name="password" id="password" id="password"
                                                placeholder="{{ __('Password') }}" required>
                                            <button class="bg-transparent btn btn-light" type="button"
                                                onclick="createpassword('password', this)">
                                                <i class="align-middle ri-eye-off-line"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mt-3 col-xl-12 d-grid">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
