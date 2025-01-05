@extends('layouts.master')

@section('page_title')
    {{ __('User') }}
@endsection

@section('section_header_title')
    {{ __('User') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item">
        <a href="{{ route('user.index') }}" class="text-white-50">
            {{ __('User') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Memperbarui Data User') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
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
                                <label for="email"
                                    class="form-label text-default">{{ __('Email (sebagai identifikasi saat login)') }}
                                    <x-all-not-null /></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') ?? ($user->email ?? '') }}"
                                    placeholder="{{ __('Email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-6">
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
                            <div class="col-xl-6">
                                <label for="join_date" class="form-label text-default">{{ __('Tanggal Bergabung') }}
                                    <x-all-not-null /></label>
                                <div class="input-group">
                                    <div class="input-group-text text-muted">
                                        <i class="ri-calendar-line"></i>
                                    </div>
                                    <input type="text"
                                        class="form-control flatpickr @error('join_date') is-invalid @enderror"
                                        name="join_date" value="{{ old('join_date') ?? ($user->join_date ?? '') }}"
                                        placeholder="{{ __('Tanggal Bergabung') }}" required>
                                    @error('join_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @can('user update')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    @endcan
                </div>
            </form>
        </div>
    </div>
@endsection

@include('layouts.includes.select2')
@include('layouts.includes.flatpickr')
