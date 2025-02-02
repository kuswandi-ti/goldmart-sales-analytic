@extends('layouts.master')

@push('styles_vendor')
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
@endpush

@section('page_title')
    {{ __('Customer Visit') }}
@endsection

@section('section_header_title')
    {{ __('Customer Visit') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <x-breadcrumb-item url="{{ route('customervisit.index') }}" title="{{ __('Customer Visit') }}" />
    <x-breadcrumb-active title="{{ __('Menambah Data Customer Visit') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('customervisit.store') }}" class="f1">
                @csrf

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Menambah Data Customer Visit') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses menambah data customer visit') }}
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
                            <div class="col-xl-12" style="text-align: center;">
                                <div class="f1-steps">
                                    <div class="f1-progress">
                                        <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4"
                                            style="width: 25%;"></div>
                                    </div>
                                    <div class="mb-3 f1-step active">
                                        <div class="mb-1 f1-step-icon">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        <p>{{ __('Melihat') }}</p>
                                    </div>
                                    <div class="mb-3 f1-step">
                                        <div class="mb-1 f1-step-icon">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <p>{{ __('Bertanya') }}</p>
                                    </div>
                                    <div class="mb-3 f1-step">
                                        <div class="mb-1 f1-step-icon">
                                            <i class="fas fa-tasks"></i>
                                        </div>
                                        <p>{{ __('Mencoba') }}</p>
                                    </div>
                                    <div class="mb-3 f1-step">
                                        <div class="mb-1 f1-step-icon">
                                            <i class="fas fa-shopping-basket"></i>
                                        </div>
                                        <p>{{ __('Membeli') }}</p>
                                    </div>
                                </div>

                                <!-- step 1 -->
                                <fieldset>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-2 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Walk In Customer" type="checkbox" role="switch"
                                                            name="param_lihat[]" id="chk-lihat-walk-in-customer">
                                                        <label class="form-check-label"
                                                            for="chk-lihat-walk-in-customer">{{ __('Walk In Customer') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-2 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="By Invitation" type="checkbox" role="switch"
                                                            name="param_lihat[]" id="chk-lihat-by-invitation">
                                                        <label class="form-check-label"
                                                            for="chk-lihat-by-invitation">{{ __('By Invitation') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-2 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="By Social Media Campaign" type="checkbox" role="switch"
                                                            name="param_lihat[]" id="chk-lihat-by-social-media-campaign">
                                                        <label class="form-check-label"
                                                            for="chk-lihat-by-social-media-campaign">{{ __('By Social Media Campaign') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-2 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="By Buy Back" type="checkbox" role="switch"
                                                            name="param_lihat[]" id="chk-lihat-by-buy-back">
                                                        <label class="form-check-label"
                                                            for="chk-lihat-by-buy-back">{{ __('By Buy Back') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-2 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Reparation" type="checkbox" role="switch"
                                                            name="param_lihat[]" id="chk-lihat-reparation">
                                                        <label class="form-check-label"
                                                            for="chk-lihat-reparation">{{ __('Reparation') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="mb-2 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger" value="Others"
                                                            type="checkbox" role="switch" name="param_lihat[]"
                                                            id="chk-lihat-others">
                                                        <label class="form-check-label"
                                                            for="chk-lihat-others">{{ __('Others') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8 mb-3" id="div-lihat-keterangan"
                                                    style="display: none">
                                                    <input type="text"
                                                        class="form-control @error('keterangan') is-invalid @enderror"
                                                        name="lihat_keterangan" id="lihat-keterangan"
                                                        value="{{ old('lihat_keterangan') }}"
                                                        placeholder="{{ __('Keterangan Others') }}">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="f1-buttons">
                                        @can('customer visit create')
                                            <button type="submit" class="btn btn-primary btn-submit">
                                                {{ __('Simpan') }}
                                            </button>
                                        @endcan
                                        <button type="button" class="btn btn-secondary btn-next">
                                            {{ __('Selanjutnya') }} <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </fieldset>

                                <!-- step 2 -->
                                <fieldset>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="mb-3 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger" value="Promo"
                                                            type="checkbox" role="switch" name="param_tanya[]"
                                                            id="chk-tanya-promo">
                                                        <label class="form-check-label"
                                                            for="chk-tanya-promo">{{ __('Promo') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="mb-3 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger" value="Barang"
                                                            type="checkbox" role="switch" name="param_tanya[]"
                                                            id="chk-tanya-barang">
                                                        <label class="form-check-label"
                                                            for="chk-tanya-barang">{{ __('Barang') }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-4 col-sm-8" id="div-tanya-brand" style="display: none">
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
                                                                            name="tanya_goldmart[]" multiple>
                                                                            @foreach ($tipe_barang->where('id_brand', 1) as $data)
                                                                                <option value="{{ $data->nama }}">
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
                                                                            name="tanya_goldmaster[]" multiple>
                                                                            @foreach ($tipe_barang->where('id_brand', 2) as $data)
                                                                                <option value="{{ $data->nama }}">
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
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Range Harga" type="checkbox" role="switch"
                                                            name="param_tanya[]" id="chk-tanya-range-harga">
                                                        <label class="form-check-label"
                                                            for="chk-tanya-range-harga">{{ __('Range Harga') }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-4 col-sm-8" id="div-tanya-range-harga"
                                                    style="display: none">
                                                    <select
                                                        class="js-example-placeholder-single js-states form-control select2"
                                                        name="tanya_rangeharga[]" multiple="multiple">
                                                        @foreach ($range_harga as $data)
                                                            <option value="{{ $data->nama }}">
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
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Buy Back" type="checkbox" role="switch"
                                                            name="param_tanya[]" id="chk-tanya-buy-back">
                                                        <label class="form-check-label"
                                                            for="chk-tanya-buy-back">{{ __('Buy Back') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-3 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Reparasi" type="checkbox" role="switch"
                                                            name="param_tanya[]" id="chk-tanya-reparasi">
                                                        <label class="form-check-label"
                                                            for="chk-tanya-reparasi">{{ __('Reparasi') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="mb-3 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger" value="Others"
                                                            type="checkbox" role="switch" name="param_tanya[]"
                                                            id="chk-tanya-others">
                                                        <label class="form-check-label"
                                                            for="chk-tanya-others">{{ __('Others') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8 mb-3" id="div-tanya-others" style="display: none">
                                                    <input type="text"
                                                        class="form-control @error('tanya_keterangan') is-invalid @enderror"
                                                        name="tanya_keterangan" id="tanya-keterangan"
                                                        value="{{ old('tanya_keterangan') }}"
                                                        placeholder="{{ __('Keterangan Others') }}">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="f1-buttons">
                                        @can('customer visit create')
                                            <button type="submit" class="btn btn-primary btn-submit">
                                                {{ __('Simpan') }}
                                            </button>
                                        @endcan
                                        <button type="button" class="btn btn-warning btn-previous">
                                            <i class="fa fa-arrow-left"></i> {{ __('Sebelumnya') }}
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-next">
                                            {{ __('Selanjutnya') }} <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </fieldset>

                                <!-- step 3 -->
                                <fieldset>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="mb-3 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Goldmart" type="checkbox" role="switch"
                                                            name="param_coba[]" id="chk-coba-goldmart">
                                                        <label class="form-check-label"
                                                            for="chk-coba-goldmart">{{ __('Goldmart') }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-4 col-sm-8" id="div-coba-goldmart" style="display: none">
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
                                                                            name="coba_goldmart[]" multiple="multiple">
                                                                            @foreach ($tipe_barang->where('id_brand', 1) as $data)
                                                                                <option value="{{ $data->nama }}">
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
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Goldmaster" type="checkbox" role="switch"
                                                            name="param_coba[]" id="chk-coba-goldmaster">
                                                        <label class="form-check-label"
                                                            for="chk-coba-goldmaster">{{ __('Goldmaster') }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-4 col-sm-8" id="div-coba-goldmaster"
                                                    style="display: none">
                                                    <div class="table-responsive mb-2">
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
                                                                            name="coba_goldmaster[]" multiple="multiple">
                                                                            @foreach ($tipe_barang->where('id_brand', 2) as $data)
                                                                                <option value="{{ $data->nama }}">
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
                                    </ul>
                                    <div class="f1-buttons">
                                        @can('customer visit create')
                                            <button type="submit" class="btn btn-primary btn-submit">
                                                {{ __('Simpan') }}
                                            </button>
                                        @endcan
                                        <button type="button" class="btn btn-warning btn-previous">
                                            <i class="fa fa-arrow-left"></i> {{ __('Sebelumnya') }}
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-next">
                                            {{ __('Selanjutnya') }} <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </fieldset>

                                <!-- step 4 -->
                                <fieldset>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="mb-3 form-check-lg form-switch">
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Goldmart" type="checkbox" role="switch"
                                                            name="param_beli[]" id="chk-beli-goldmart">
                                                        <label class="form-check-label"
                                                            for="chk-beli-goldmart">{{ __('Goldmart') }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-4 col-sm-8" id="div-beli-goldmart" style="display: none">
                                                    <div class="table-responsive mb-2">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{ __('Tipe Barang') }}</th>
                                                                    <th scope="col">{{ __('Qty') }}</th>
                                                                    <th scope="col">{{ __('Nominal (Rp.)') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($tipe_barang->where('id_brand', 1) as $data)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="beli_tipe_barang_goldmart[]"
                                                                                value="{{ $data->nama }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control number-only empty-default"
                                                                                name="beli_qty_goldmart[]" value="">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control number-only empty-default"
                                                                                name="beli_nominal_goldmart[]"
                                                                                value="">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
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
                                                        <input class="form-check-input form-checked-danger"
                                                            value="Goldmaster" type="checkbox" role="switch"
                                                            name="param_beli[]" id="chk-beli-goldmaster">
                                                        <label class="form-check-label"
                                                            for="chk-beli-goldmaster">{{ __('Goldmaster') }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-4 col-sm-8" id="div-beli-goldmaster"
                                                    style="display: none">
                                                    <div class="table-responsive mb-2">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{ __('Tipe Barang') }}</th>
                                                                    <th scope="col">{{ __('Qty') }}</th>
                                                                    <th scope="col">{{ __('Nominal (Rp.)') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($tipe_barang->where('id_brand', 2) as $data)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="beli_tipe_barang_goldmaster[]"
                                                                                value="{{ $data->nama }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control number-only empty-default"
                                                                                name="beli_qty_goldmaster[]"
                                                                                value="">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control number-only empty-default"
                                                                                name="beli_nominal_goldmaster[]"
                                                                                value="">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="f1-buttons">
                                        @can('customer visit create')
                                            <button type="submit" class="btn btn-primary btn-submit">
                                                {{ __('Simpan') }}
                                            </button>
                                        @endcan
                                        <button type="button" class="btn btn-warning btn-previous">
                                            <i class="fa fa-arrow-left"></i> {{ __('Sebelumnya') }}
                                        </button>
                                        @can('transaksi bayar')
                                            <button type="submit" class="btn btn-danger btn-submit">
                                                {{ __('Bayar') }}
                                            </button>
                                        @endcan
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@include('layouts.includes.select2')

@push('styles')
    @include('layouts.partials._style_wizard')
@endpush

@push('scripts')
    <script>
        $(function() {
            /* Step 1 */
            $("#chk-lihat-others").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-lihat-keterangan").show();
                } else {
                    $("#div-lihat-keterangan").hide();
                }
            });

            /* Step 2 */
            $("#chk-tanya-barang").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-tanya-brand").show();
                } else {
                    $("#div-tanya-brand").hide();
                }
            });

            $("#chk-tanya-range-harga").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-tanya-range-harga").show();
                } else {
                    $("#div-tanya-range-harga").hide();
                }
            });

            $("#chk-tanya-others").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-tanya-others").show();
                } else {
                    $("#div-tanya-others").hide();
                }
            });

            /* Step 3 */
            $("#chk-coba-goldmart").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-coba-goldmart").show();
                } else {
                    $("#div-coba-goldmart").hide();
                }
            });

            $("#chk-coba-goldmaster").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-coba-goldmaster").show();
                } else {
                    $("#div-coba-goldmaster").hide();
                }
            });

            /* Step 4 */
            $("#chk-beli-goldmart").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-beli-goldmart").show();
                } else {
                    $("#div-beli-goldmart").hide();
                }
            });

            $("#chk-beli-goldmaster").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-beli-goldmaster").show();
                } else {
                    $("#div-beli-goldmaster").hide();
                }
            });
        });

        @include('layouts.partials._scripts_wizard')
    </script>
@endpush
