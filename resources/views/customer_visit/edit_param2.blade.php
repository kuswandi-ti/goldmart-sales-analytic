@extends('layouts.master')

@section('page_title')
    {{ __('Customer Visit (Bertanya)') }}
@endsection

@section('section_header_title')
    {{ __('Customer Visit (Bertanya)') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item">
        <a href="{{ route('rangeharga.index') }}" class="text-white-50">
            {{ __('Customer Visit (Bertanya)') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Memperbarui Data Customer Visit (Bertanya)') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('customervisit.update', $customer_visit->id) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="choice_param" value="param2">
                <input type="hidden" name="proses_param" value="1">

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Memperbarui Data Customer Visit (Bertanya)') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses memperbarui data customer visit (bertanya)') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('customervisit.index') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-6">
                                <label for="no_dokumen" class="form-label text-default">{{ __('Nomor Dokumen') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('no_dokumen') is-invalid @enderror"
                                    name="no_dokumen"
                                    value="{{ old('no_dokumen') ?? ($customer_visit->no_dokumen ?? '') }}"
                                    placeholder="{{ __('Nomor Dokumen') }}" disabled>
                                @error('no_dokumen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <label for="tgl_visit" class="form-label text-default">{{ __('Tgl Visit') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('tgl_visit') is-invalid @enderror"
                                    name="tgl_visit" value="{{ old('tgl_visit') ?? ($customer_visit->tgl_visit ?? '') }}"
                                    placeholder="{{ __('Tgl Visit') }}" disabled>
                                @error('tgl_visit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-6">
                                <label for="nama_sales" class="form-label text-default">{{ __('Sales Person') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('nama_sales') is-invalid @enderror"
                                    name="nama_sales"
                                    value="{{ old('nama_sales') ?? ($customer_visit->nama_sales ?? '') }}"
                                    placeholder="{{ __('Sales Person') }}" disabled>
                                @error('nama_sales')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <label for="store" class="form-label text-default">{{ __('Store') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('store') is-invalid @enderror"
                                    name="store"
                                    value="{{ old('store') ?? ($customer_visit->nama_store . ' - ' . $customer_visit->kota_store ?? '') }}"
                                    placeholder="{{ __('Store') }}" disabled>
                                @error('store')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Promo"
                                                type="checkbox" role="switch" name="param[]" id="chk-promo"
                                                {{ in_array('Promo', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chk-promo">{{ __('Promo') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Barang"
                                                type="checkbox" role="switch" name="param[]" id="chk-barang"
                                                {{ in_array('Barang', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chk-barang">{{ __('Barang') }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-sm-8" id="div-brand" style="display: none">
                                        <div class="table-responsive mb-2">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ __('Goldmart') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td width="50%">
                                                            <select
                                                                class="js-example-placeholder-single js-states form-control select2"
                                                                name="goldmart[]" multiple>
                                                                @foreach ($tipe_barang->where('id_brand', 1) as $data)
                                                                    <option value="{{ $data->nama }}"
                                                                        {{ in_array($data->nama, $customer_visit_detail_parameter_3_barang_goldmart) ? 'selected' : '' }}>
                                                                        {{ $data->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ __('Goldmaster') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td width="50%">
                                                            <select
                                                                class="js-example-placeholder-single js-states form-control select2"
                                                                name="goldmaster[]" multiple>
                                                                @foreach ($tipe_barang->where('id_brand', 2) as $data)
                                                                    <option value="{{ $data->nama }}"
                                                                        {{ in_array($data->nama, $customer_visit_detail_parameter_3_barang_goldmaster) ? 'selected' : '' }}>
                                                                        {{ $data->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Range Harga"
                                                type="checkbox" role="switch" name="param[]" id="chk-range-harga"
                                                {{ in_array('Range Harga', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-range-harga">{{ __('Range Harga') }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-sm-8" id="div-range-harga" style="display: none">
                                        <select class="js-example-placeholder-single js-states form-control select2"
                                            name="rangeharga[]" multiple="multiple">
                                            @foreach ($range_harga as $data)
                                                <option value="{{ $data->nama }}"
                                                    {{ in_array($data->nama, $customer_visit_detail_parameter_2_range_harga) ? 'selected' : '' }}>
                                                    {{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Buy Back"
                                                type="checkbox" role="switch" name="param[]" id="chk-buy-back"
                                                {{ in_array('Buy Back', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-buy-back">{{ __('Buy Back') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Reparasi"
                                                type="checkbox" role="switch" name="param[]" id="chk-reparasi"
                                                {{ in_array('Reparasi', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-reparasi">{{ __('Reparasi') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Others"
                                                type="checkbox" role="switch" name="param[]" id="chk-others"
                                                {{ in_array('Others', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chk-others">{{ __('Others') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 mb-3" id="div-others" style="display: none">
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            name="keterangan" id="keterangan" value="{{ old('keterangan') ?? ($customer_visit_detail_parameter_2_others->parameter_2 ?? '') }}"
                                            placeholder="{{ __('Keterangan Others') }}">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @can('customer visit update')
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

@push('scripts')
    <script>
        $(function() {
            $("#chk-barang").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-brand").show();
                } else {
                    $("#div-brand").hide();
                }
            });

            $("#chk-range-harga").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-range-harga").show();
                } else {
                    $("#div-range-harga").hide();
                }
            });

            $("#chk-others").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-others").show();
                } else {
                    $("#div-others").hide();
                }
            });
        });

        $(document).ready(function() {
            if ($("#chk-barang").attr("checked")) {
                $("#div-brand").show();
            }
            if ($("#chk-range-harga").attr("checked")) {
                $("#div-range-harga").show();
            }
            if ($("#chk-others").attr("checked")) {
                $("#div-others").show();
            }
        });
    </script>
@endpush
