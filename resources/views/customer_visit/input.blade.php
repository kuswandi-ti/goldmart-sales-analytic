@extends('layouts.master')

@section('page_title')
    {{ __('Customer Visit') }}
@endsection

@section('section_header_title')
    {{ __('Customer Visit') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item">
        <a href="{{ route('customervisit.index') }}" class="text-white-50">
            {{ __('Customer Visit') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Menambah Data Customer Visit') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card border border-info">
                <a aria-label="anchor" href="{{ route('customervisit.param1') }}" class="card-anchor"></a>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar avatar-xl">
                                <img src="{{ url(config('common.path_template') . 'assets/images/lihat.png') }}"
                                    alt="img">
                            </span>
                        </div>
                        <div>
                            <p class="card-text text-info mb-1 fs-14 fw-semibold">
                                {{ __('Melihat') }}
                            </p>
                            <div class="card-title text-muted fs-11 mb-0">
                                {{ __('Pilih menu ini jika customer yang datang hanya untuk melihat produk') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card border border-info">
                <a aria-label="anchor" href="{{ route('customervisit.param2') }}" class="card-anchor"></a>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar avatar-xl">
                                <img src="{{ url(config('common.path_template') . 'assets/images/tanya.png') }}"
                                    alt="img">
                            </span>
                        </div>
                        <div>
                            <p class="card-text text-info mb-1 fs-14 fw-semibold">
                                {{ __('Bertanya') }}
                            </p>
                            <div class="card-title text-muted fs-11 mb-0">
                                {{ __('Pilih menu ini jika customer yang datang bertanya tentang produk') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card border border-info">
                <a aria-label="anchor" href="{{ route('customervisit.param3') }}" class="card-anchor"></a>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar avatar-xl">
                                <img src="{{ url(config('common.path_template') . 'assets/images/coba.png') }}"
                                    alt="img">
                            </span>
                        </div>
                        <div>
                            <p class="card-text text-info mb-1 fs-14 fw-semibold">
                                {{ __('Mencoba') }}
                            </p>
                            <div class="card-title text-muted fs-11 mb-0">
                                {{ __('Pilih menu ini jika customer yang datang mencoba produk') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card border border-info">
                <a aria-label="anchor" href="{{ route('customervisit.param4') }}" class="card-anchor"></a>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar avatar-xl">
                                <img src="{{ url(config('common.path_template') . 'assets/images/beli.png') }}"
                                    alt="img">
                            </span>
                        </div>
                        <div>
                            <p class="card-text text-info mb-1 fs-14 fw-semibold">
                                {{ __('Membeli') }}
                            </p>
                            <div class="card-title text-muted fs-11 mb-0">
                                {{ __('Pilih menu ini jika customer yang datang melakukan pembelian produk') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.includes.select2')

@push('scripts')
    <script></script>
@endpush
