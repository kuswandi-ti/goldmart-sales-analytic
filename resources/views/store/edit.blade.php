@extends('layouts.master')

@section('page_title')
    {{ __('Store') }}
@endsection

@section('section_header_title')
    {{ __('Store') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item">
        <a href="{{ route('store.index') }}" class="text-white-50">
            {{ __('Store') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Memperbarui Data Store') }}</li> --}}
    <x-breadcrumb-item url="{{ route('store.index') }}" title="{{ __('Store') }}" />
    <x-breadcrumb-active title="{{ __('Memperbarui Data Store') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('store.update', $store) }}">
                @csrf
                @method('PUT')

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Memperbarui Data Store') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses memperbarui data store') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('store.index') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="kode" class="form-label text-default">{{ __('Kode Store') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    name="kode" value="{{ old('kode') ?? ($store->kode ?? '') }}"
                                    placeholder="{{ __('Kode Store') }}" disabled>
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="nama" class="form-label text-default">{{ __('Nama Store') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama') ?? ($store->nama ?? '') }}"
                                    placeholder="{{ __('Nama Store') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="kota" class="form-label text-default">{{ __('Kota') }}
                                    <x-all-not-null /></label>
                                <select
                                    class="js-example-placeholder-single js-states form-control select2 @error('kota') is-invalid @enderror"
                                    name="kota" id="kota" required>
                                    @foreach ($kota as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('kota') == $key ? 'selected' : ($store->kota == $key ? 'selected' : '') }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('kota')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @can('store update')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Perbarui') }}
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
