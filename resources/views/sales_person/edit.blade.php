@extends('layouts.master')

@section('page_title')
    {{ __('Sales Person') }}
@endsection

@section('section_header_title')
    {{ __('Sales Person') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item">
        <a href="{{ route('salesperson.index') }}" class="text-white-50">
            {{ __('Sales Person') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Memperbarui Data Sales Person') }}</li> --}}
    <x-breadcrumb-item url="{{ route('salesperson.index') }}" title="{{ __('Sales Person') }}" />
    <x-breadcrumb-active title="{{ __('Memperbarui Data Sales Person') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('salesperson.update', $salesperson) }}">
                @csrf
                @method('PUT')

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Memperbarui Data Sales Person') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses memperbarui data sales person') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('salesperson.index') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="kode" class="form-label text-default">{{ __('Kode Sales Person') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    name="kode" value="{{ old('kode') ?? ($salesperson->kode ?? '') }}"
                                    placeholder="{{ __('Kode Sales Person') }}" disabled>
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="nama" class="form-label text-default">{{ __('Nama Sales Person') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama') ?? ($salesperson->nama ?? '') }}"
                                    placeholder="{{ __('Nama Sales Person') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="nik" class="form-label text-default">{{ __('NIK Sales Person') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                                    value="{{ old('nik') ?? ($salesperson->nik ?? '') }}"
                                    placeholder="{{ __('NIK Sales Person') }}" required>
                                @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="store" class="form-label text-default">{{ __('Store') }}
                                    <x-all-not-null /></label>
                                <select
                                    class="js-example-placeholder-single js-states form-control select2 @error('store') is-invalid @enderror"
                                    name="store" id="store" required>
                                    @foreach ($store as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('store') == $key ? 'selected' : ($salesperson->id_store == $key ? 'selected' : '') }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('store')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @can('sales person update')
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
