@extends('layouts.master')

@section('page_title')
    {{ __('Customer Visit (Membeli)') }}
@endsection

@section('section_header_title')
    {{ __('Customer Visit (Membeli)') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item">
        <a href="{{ route('rangeharga.index') }}" class="text-white-50">
            {{ __('Customer Visit (Membeli)') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Memperbarui Data Customer Visit (Membeli)') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('customervisit.update', $customer_visit->id) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="choice_param" value="param4">
                <input type="hidden" name="proses_param" value="3">

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Memperbarui Data Customer Visit (Membeli)') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses memperbarui data customer visit (membeli)') }}
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
                                            <input class="form-check-input form-checked-danger" value="Goldmart"
                                                type="checkbox" role="switch" name="param[]" id="chk-goldmart"
                                                {{ in_array('Goldmart', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chk-goldmart">{{ __('Goldmart') }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-sm-8" id="div-goldmart" style="display: none">
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
                                                                    name="tipe_barang_goldmart[]"
                                                                    value="{{ $data->nama }}" readonly>
                                                            </td>
                                                            <td>
                                                                @if (count($customer_visit_detail_parameter_2_goldmart->where('parameter_2', $data->nama)) > 0)
                                                                    @foreach ($customer_visit_detail_parameter_2_goldmart->where('parameter_2', $data->nama) as $row)
                                                                        <input type="text"
                                                                            class="form-control number-only empty-default"
                                                                            name="qty_goldmart[]"
                                                                            value="{{ formatAmount($row->qty) ?? '' }}">
                                                                    @endforeach
                                                                @else
                                                                    <input type="text"
                                                                        class="form-control number-only empty-default"
                                                                        name="qty_goldmart[]" value="">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (count($customer_visit_detail_parameter_2_goldmart->where('parameter_2', $data->nama)) > 0)
                                                                    @foreach ($customer_visit_detail_parameter_2_goldmart->where('parameter_2', $data->nama) as $row)
                                                                        <input type="text"
                                                                            class="form-control number-only empty-default"
                                                                            name="nominal_goldmart[]"
                                                                            value="{{ formatAmount($row->nominal) ?? '' }}">
                                                                    @endforeach
                                                                @else
                                                                    <input type="text"
                                                                        class="form-control number-only empty-default"
                                                                        name="nominal_goldmart[]" value="">
                                                                @endif
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
                                            <input class="form-check-input form-checked-danger" value="Goldmaster"
                                                type="checkbox" role="switch" name="param[]" id="chk-goldmaster"
                                                {{ in_array('Goldmaster', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-goldmaster">{{ __('Goldmaster') }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-sm-8" id="div-goldmaster" style="display: none">
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
                                                                    name="tipe_barang_goldmaster[]"
                                                                    value="{{ $data->nama }}" readonly>
                                                            </td>
                                                            <td>
                                                                @if (count($customer_visit_detail_parameter_2_goldmaster->where('parameter_2', $data->nama)) > 0)
                                                                    @foreach ($customer_visit_detail_parameter_2_goldmaster->where('parameter_2', $data->nama) as $row)
                                                                        <input type="text"
                                                                            class="form-control number-only empty-default"
                                                                            name="qty_goldmaster[]"
                                                                            value="{{ formatAmount($row->qty) ?? '' }}">
                                                                    @endforeach
                                                                @else
                                                                    <input type="text"
                                                                        class="form-control number-only empty-default"
                                                                        name="qty_goldmaster[]" value="">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (count($customer_visit_detail_parameter_2_goldmaster->where('parameter_2', $data->nama)) > 0)
                                                                    @foreach ($customer_visit_detail_parameter_2_goldmaster->where('parameter_2', $data->nama) as $row)
                                                                        <input type="text"
                                                                            class="form-control number-only empty-default"
                                                                            name="nominal_goldmaster[]"
                                                                            value="{{ formatAmount($row->nominal) ?? '' }}">
                                                                    @endforeach
                                                                @else
                                                                    <input type="text"
                                                                        class="form-control number-only empty-default"
                                                                        name="nominal_goldmaster[]" value="">
                                                                @endif
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

        $(document).ready(function() {
            if ($("#chk-goldmart").attr("checked")) {
                $("#div-goldmart").show();
            }
            if ($("#chk-goldmaster").attr("checked")) {
                $("#div-goldmaster").show();
            }
        });
    </script>
@endpush
