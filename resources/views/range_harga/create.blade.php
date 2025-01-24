@extends('layouts.master')

@section('page_title')
    {{ __('Range Harga') }}
@endsection

@section('section_header_title')
    {{ __('Range Harga') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item">
        <a href="{{ route('rangeharga.index') }}" class="text-white-50">
            {{ __('Range Harga') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Menambah Data Range Harga') }}</li> --}}
    <x-breadcrumb-item url="{{ route('rangeharga.index') }}" title="{{ __('Range Harga') }}" />
    <x-breadcrumb-active title="{{ __('Menambah Data Range Harga') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('rangeharga.store') }}">
                @csrf

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Menambah Data Range Harga') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses menambah data range harga') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('rangeharga.index') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="nama" class="form-label text-default">{{ __('Deskripsi') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama"
                                    value="{{ old('nama') ?? (!empty($rangeharga) ? $rangeharga->nama : '') }}"
                                    placeholder="{{ __('Deskripsi') }}" required autofocus>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-6">
                                <label for="harga_min" class="form-label text-default">{{ __('Harga Min.') }}
                                    <x-all-not-null /></label>
                                <input type="text"
                                    class="form-control number-only zero-default @error('harga_min') is-invalid @enderror"
                                    name="harga_min" id="harga_min" value="{{ old('harga_min') }}"
                                    placeholder="{{ __('Harga Min.') }}" required>
                                @error('harga_min')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <label for="harga_max" class="form-label text-default">{{ __('Harga Max.') }}
                                    <x-all-not-null /></label>
                                <input type="text"
                                    class="form-control number-only zero-default @error('harga_max') is-invalid @enderror"
                                    name="harga_max" value="{{ old('harga_max') }}" placeholder="{{ __('Harga Max.') }}"
                                    required>
                                @error('harga_max')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @can('range harga create')
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
