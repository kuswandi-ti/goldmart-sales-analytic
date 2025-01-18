@extends('layouts.master')

@section('page_title')
    {{ __('Customer Visit (Melihat)') }}
@endsection

@section('section_header_title')
    {{ __('Customer Visit (Melihat)') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item">
        <a href="{{ route('rangeharga.index') }}" class="text-white-50">
            {{ __('Customer Visit (Melihat)') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Memperbarui Data Customer Visit (Melihat)') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('customervisit.update', $customer_visit->id) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="choice_param" value="param1">
                <input type="hidden" name="proses_param" value="0">

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Memperbarui Data Customer Visit (Melihat)') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses memperbarui data customer visit (melihat)') }}
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
                                    <div class="col-sm-12">
                                        <div class="mb-2 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Walk In Customer"
                                                type="checkbox" role="switch" name="param[]" id="chk-walk-in-customer"
                                                {{ in_array('Walk In Customer', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-walk-in-customer">{{ __('Walk In Customer') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="By Invitation"
                                                type="checkbox" role="switch" name="param[]" id="chk-by-invitation"
                                                {{ in_array('By Invitation', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-by-invitation">{{ __('By Invitation') }}</label>
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
                                                name="param[]" id="chk-by-social-media-campaign"
                                                {{ in_array('By Social Media Campaign', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-by-social-media-campaign">{{ __('By Social Media Campaign') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="By Buy Back"
                                                type="checkbox" role="switch" name="param[]" id="chk-by-buy-back"
                                                {{ in_array('By Buy Back', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-by-buy-back">{{ __('By Buy Back') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Reparation"
                                                type="checkbox" role="switch" name="param[]" id="chk-reparation"
                                                {{ in_array('Reparation', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="chk-reparation">{{ __('Reparation') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-2 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Others"
                                                type="checkbox" role="switch" name="param[]" id="chk-others"
                                                {{ in_array('Others', $customer_visit_detail_parameter_1) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chk-others">{{ __('Others') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 mb-3" id="div-keterangan" style="display: none">
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            name="keterangan" id="keterangan"
                                            value="{{ old('keterangan') ?? ($customer_visit_detail_parameter_2->parameter_2 ?? '') }}"
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

@push('scripts')
    <script>
        $(function() {
            $("#chk-others").click(function() {
                if ($(this).is(":checked")) {
                    $("#div-keterangan").show();
                } else {
                    $("#div-keterangan").hide();
                }
            });
        });

        $(document).ready(function() {
            if ($("#chk-others").attr("checked")) {
                $("#div-keterangan").show();
            }
        });
    </script>
@endpush
