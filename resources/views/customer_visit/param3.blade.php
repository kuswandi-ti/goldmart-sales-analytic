@extends('layouts.master')

@section('page_title')
    {{ __('Customer Visit (Mencoba)') }}
@endsection

@section('section_header_title')
    {{ __('Customer Visit (Mencoba)') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item">
        <a href="{{ route('customervisit.input') }}" class="text-white-50">
            {{ __('Customer Visit Input') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Menambah Data Customer Visit (Mencoba)') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('customervisit.store') }}">
                @csrf

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Menambah Data Customer Visit (Mencoba)') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses menambah data customer visit (mencoba)') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('customervisit.input') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-12">
                                        @foreach ($brand as $item)
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="mb-3 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="{{ $item->nama }}" type="checkbox" role="switch"
                                                            name="brands[]" id="{{ $item->id }}">
                                                        <label class="form-check-label"
                                                            for="{{ $item->id }}">{{ $item->nama }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-10 mb-3" id="div-tipe-barang">
                                                    <select
                                                        class="js-example-placeholder-single js-states form-control select2"
                                                        name="tipebarang[]" multiple="multiple">
                                                        @foreach ($tipe_barang->where('id_brand', $item->id) as $data)
                                                            <option value="{{ $data->id }}">
                                                                {{ $data->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    @can('customer visit create')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
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
