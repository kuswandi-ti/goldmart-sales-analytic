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

                <input type="hidden" name="choice_param" value="param3">
                <input type="hidden" name="proses_param" value="2">

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
                                    <div class="col-sm-4">
                                        <div class="mb-3 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Goldmart"
                                                type="checkbox" role="switch" name="param[]" id="chk-goldmart">
                                            <label class="form-check-label" for="chk-goldmart">{{ __('Goldmart') }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-sm-8" id="div-goldmart" style="display: none">
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
                                                                name="goldmart[]" multiple="multiple">
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
                                            <input class="form-check-input form-checked-danger" value="Goldmaster"
                                                type="checkbox" role="switch" name="param[]" id="chk-goldmaster">
                                            <label class="form-check-label"
                                                for="chk-goldmaster">{{ __('Goldmaster') }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-sm-8" id="div-goldmaster" style="display: none">
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
                                                                name="goldmaster[]" multiple="multiple">
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
    <script>
        $(function() {
            $("#chk-goldmart").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-goldmart").show();
                } else {
                    $("#div-goldmart").hide();
                }
            });

            $("#chk-goldmaster").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-goldmaster").show();
                } else {
                    $("#div-goldmaster").hide();
                }
            });
        });
    </script>
@endpush
