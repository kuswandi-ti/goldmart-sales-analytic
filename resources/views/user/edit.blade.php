@extends('layouts.master')

@section('page_title')
    {{ __('User') }}
@endsection

@section('section_header_title')
    {{ __('User') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item">
        <a href="{{ route('user.index') }}" class="text-white-50">
            {{ __('User') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Memperbarui Data User') }}</li> --}}
    <x-breadcrumb-item url="{{ route('user.index') }}" title="{{ __('User') }}" />
    <x-breadcrumb-active title="{{ __('Memperbarui Data User') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <form method="POST" action="{{ route('user.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Memperbarui Data User') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses memperbarui data user') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('user.index') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="name" class="form-label text-default">{{ __('Nama User') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') ?? ($user->name ?? '') }}"
                                    placeholder="{{ __('Nama User') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="sales_person" class="form-label text-default">{{ __('Sales Person') }}
                                    <x-all-not-null /></label>
                                <select
                                    class="js-example-placeholder-single js-states form-control select2 @error('sales_person') is-invalid @enderror"
                                    name="sales_person" id="sales_person" required>
                                    @foreach ($sales_person as $data)
                                        <option value="{{ $data->id }}"
                                            {{ old('sales_person') == $data->id ? 'selected' : ($user->id_sales_person == $data->id ? 'selected' : '') }}
                                            data-nik="{{ $data->nik }} ">
                                            {{ $data->nama }}</option>
                                    @endforeach
                                </select>
                                @error('sales_person')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="email"
                                    class="form-label text-default">{{ __('Email (sebagai identifikasi saat login)') }}
                                    <x-all-not-null /></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') ?? ($user->email ?? '') }}"
                                    placeholder="{{ __('Email (sebagai identifikasi saat login)') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="nik"
                                    class="form-label text-default">{{ __('NIK (sebagai identifikasi saat login)') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                                    id="nik" value="{{ old('nik') ?? ($user->nik ?? '') }}"
                                    placeholder="{{ __('NIK (sebagai identifikasi saat login)') }}" required>
                                @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="role" class="form-label text-default">{{ __('Role') }}
                                    <x-all-not-null /></label>
                                <select
                                    class="js-example-placeholder-single js-states form-control select2 @error('role') is-invalid @enderror"
                                    name="role" id="role" required>
                                    @foreach ($roles as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('role') == $key ? 'selected' : ($user->roles->pluck('id')->first() == $key ? 'selected' : '') }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @can('user update')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Perbarui') }}
                            </button>
                        </div>
                    @endcan
                </div>
            </form>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <form method="post" action="{{ route('user.password_update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{ __('Update Password') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Silahkan update password akun anda') }}
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="password" class="form-label text-default">{{ __('Password Baru') }}
                                    <x-all-not-null /></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="{{ __('Password Baru') }}">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-xl-12">
                                <label for="password_confirmation"
                                    class="form-label text-default">{{ __('Konfirmasi Password Baru') }}
                                    <x-all-not-null /></label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" placeholder="{{ __('Konfirmasi Password Baru') }}">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Perbarui') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<x-web-sweet-alert />

@include('layouts.includes.select2')
@include('layouts.includes.flatpickr')

@push('scripts')
    <script>
        $(document).ready(function() {
            // let email = $('#email').val();
            // if (IsEmail(email) === false) {
            //     $('#email').attr('readonly', true);
            // } else {
            //     $('#email').removeAttr("readonly");
            // }

            $('#sales_person').change(function() {
                var nik = $("#sales_person option:selected").data("nik");
                if (nik.length > 0) {
                    $('#nik').val($.trim(nik));
                    $('#nik').attr('readonly', true);
                } else {
                    // $('#email').val("");
                    // $('#email').removeAttr("readonly");
                    // $('#email').focus();
                    $('#nik').val('');
                    $('#nik').attr('readonly', true);
                }
            });
        });
    </script>
@endpush
