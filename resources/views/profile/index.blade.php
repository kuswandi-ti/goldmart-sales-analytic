@extends('layouts.master')

@section('page_title')
    {{ __('Profil') }}
@endsection

@section('section_header_title')
    {{ __('Profil') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item active" aria-current="page">{{ __('Profil') }}</li> --}}
    <x-breadcrumb-active title="{{ __('Profil') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <form method="post" action="{{ route('profile.update', auth()->user()->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{ __('Update Profil User') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Silahkan sesuaikan data user anda') }}
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="border shadow-none card custom-card border-dashed-primary">
                                <div class="p-3 text-center card-body">
                                    <a href="javascript:void(0);">
                                        <div class="justify-content-between">
                                            <div class="mb-2 file-format-icon">
                                                <div class="text-center">
                                                    <img src="{{ !empty(auth()->user()->image) ? url(config('common.path_storage') . auth()->user()->image) : url(config('common.path_template') . config('common.image_user_profile_big')) }}"
                                                        class="img-fluid rounded preview-path_image" width="150"
                                                        height="175">
                                                </div>
                                            </div>
                                            <div>
                                                <span class="fw-semibold">
                                                    {{ __('Gambar Profil') }}
                                                </span>
                                                <span class="fs-10 d-block text-muted">
                                                    (150 x 175)
                                                </span>
                                                <div class="mt-3">
                                                    <input class="form-control" type="file" name="image"
                                                        onchange="preview('.preview-path_image', this.files[0])">
                                                    <input type="hidden" name="old_image"
                                                        value="{{ auth()->user()->image ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="name" class="form-label text-default">{{ __('Nama') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name') ?? $user->name }}"
                                    placeholder="{{ __('Nama') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-xl-12">
                                <label for="email" class="form-label text-default">{{ __('Email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') ?? $user->email }}"
                                    placeholder="{{ __('Email') }}" disabled>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-xl-12">
                                <label for="nik" class="form-label text-default">{{ __('NIK') }}</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                                    id="nik" value="{{ old('nik') ?? $user->nik }}"
                                    placeholder="{{ __('NIK') }}" disabled>
                            </div>

                            <div class="col-xl-12">
                                <label for="join_date" class="form-label text-default">{{ __('Tgl Bergabung') }}</label>
                                <input type="text" class="form-control @error('join_date') is-invalid @enderror"
                                    name="join_date" id="join_date" value="{{ old('join_date') ?? $user->join_date }}"
                                    placeholder="{{ __('Tgl Bergabung') }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Simpan') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <form method="post" action="{{ route('profile_password.update', $user->id) }}">
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
                                <label for="current_password" class="form-label text-default">{{ __('Password Saat Ini') }}
                                    <x-all-not-null /></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" placeholder="{{ __('Password Saat Ini') }}">
                                @error('current_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
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
                            {{ __('Simpan') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- @can('transaksi bayar')
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{ __('Order') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data order anda') }}
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('No. Invoice') }}</th>
                                        <th scope="col">{{ __('Tgl Invoice') }}</th>
                                        <th scope="col">{{ __('Total (Rp.)') }}</th>
                                        <th scope="col">{{ __('Status Bayar') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order as $row)
                                        <tr>
                                            <th scope="row">{{ $row->no_dokumen }}</th>
                                            <td>{{ $row->created_at }}</td>
                                            <td>{{ formatAmount($row->nominal) }}</td>
                                            <td><span
                                                    class="badge {{ setStatusBayarBadge($row->status_bayar) }}">{{ strtoupper($row->status_bayar) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            Data Post belum Tersedia.
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan --}}
@endsection

<x-web-sweet-alert />
