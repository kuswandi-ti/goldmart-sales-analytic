@extends('layouts.master')

@section('page_title')
    {{ __('Range Harga') }}
@endsection

@section('section_header_title')
    {{ __('Range Harga') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item">
        <a href="{{ route('rangeharga.index') }}" class="text-white-50">
            {{ __('Range Harga') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Memperbarui Data Range Harga') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('rangeharga.update', $rangeharga) }}">
                @csrf
                @method('PUT')

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Memperbarui Data Brand') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses memperbarui data range harga') }}
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
                                    name="nama" value="{{ old('nama') ?? ($rangeharga->nama ?? '') }}"
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
                                <input type="number"
                                    class="form-control number-only zero-default @error('harga_min') is-invalid @enderror"
                                    name="harga_min" id="harga_min"
                                    value="{{ old('harga_min') ?? (!empty($rangeharga) ? $rangeharga->harga_min : 0) }}"
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
                                <input type="number"
                                    class="form-control number-only zero-default @error('harga_max') is-invalid @enderror"
                                    name="harga_max"
                                    value="{{ old('harga_max') ?? (!empty($rangeharga) ? $rangeharga->harga_max : 0) }}"
                                    placeholder="{{ __('Harga Max.') }}" required>
                                @error('harga_max')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @can('range harga update')
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
