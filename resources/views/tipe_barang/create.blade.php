@extends('layouts.master')

@section('page_title')
    {{ __('Tipe Barang') }}
@endsection

@section('section_header_title')
    {{ __('Tipe Barang') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item">
        <a href="{{ route('tipebarang.index') }}" class="text-white-50">
            {{ __('Tipe Barang') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Menambah Data Tipe Barang') }}</li> --}}
    <x-breadcrumb-item url="{{ route('tipebarang.index') }}" title="{{ __('Tipe Barang') }}" />
    <x-breadcrumb-active title="{{ __('Menambah Data Tipe Barang') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('tipebarang.store') }}">
                @csrf

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Menambah Data Tipe Barang') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses menambah data tipe barang') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('tipebarang.index') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="nama" class="form-label text-default">{{ __('Nama Tipe Barang') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama') }}" placeholder="{{ __('Nama Tipe Barang') }}"
                                    required>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="brand" class="form-label text-default">{{ __('Brand') }}
                                    <x-all-not-null /></label>
                                <select
                                    class="js-example-placeholder-single js-states form-control select2 @error('brand') is-invalid @enderror"
                                    name="brand" id="brand" required>
                                    @foreach ($brands as $key => $value)
                                        <option value="{{ $key }}" {{ old('brand') == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('brand')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @can('tipe barang create')
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

@push('scripts')
    <script></script>
@endpush
