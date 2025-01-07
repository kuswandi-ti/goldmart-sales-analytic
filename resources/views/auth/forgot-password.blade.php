@extends('layouts.auth')

@section('page_title')
    {{ __('Lupa Password') }}
@endsection

@section('content')
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4">
                <img class="login-intro-img" src="{{ url(config('common.path_template') . 'img/sales-illustration.webp') }}"
                    alt="">
            </div>

            <x-web-alert-message />

            <form method="POST" action="{{ route('forgot_password.send') }}">
                @csrf

                <div class="register-form mt-4">
                    <h6 class="mb-3 text-center">{{ __('Lupa Password') }}</h6>

                    <div class="form-group">
                        <input class="form-control @error('email') is-invalid @enderror" type="text" name="email"
                            id="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button class="btn btn-primary w-100" type="submit">{{ __('Kirim Link Reset Password') }}</button>
                </div>

                <div class="login-meta-data text-center">
                    <a href="{{ route('login') }}" class="stretched-link forgot-password d-block mt-3 mb-1">
                        {{ __('Login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
