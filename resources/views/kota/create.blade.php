@extends('layouts.master')

@section('page_title')
    {{ __('Kota') }}
@endsection

@section('section_header_title')
    {{ __('Kota') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item">
        <a href="{{ route('kotas.index') }}" class="text-white-50">
            {{ __('Kota') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Menambah Data Kota') }}</li> --}}
    <x-breadcrumb-item url="{{ route('kotas.index') }}" title="{{ __('Kota') }}" />
    <x-breadcrumb-active title="{{ __('Menambah Data Kota') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('kotas.store') }}">
                @csrf

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Menambah Data Kota') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses menambah data kota') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('kotas.index') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-xl-12">
                                <label for="nama" class="form-label text-default">{{ __('Nama Kota') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama') ?? (!empty($brand) ? $kota->nama : '') }}"
                                    placeholder="{{ __('Nama Kota') }}" required autofocus>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @can('kota create')
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
