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
        <a href="{{ route('customervisit.input') }}" class="text-white-50">
            {{ __('Customer Visit Input') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Menambah Data Customer Visit (Melihat)') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('customervisit.store') }}">
                @csrf

                <input type="hidden" name="choice_param" value="param1">
                <input type="hidden" name="proses_param" value="0">

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Menambah Data Customer Visit (Melihat)') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses menambah data customer visit (melihat)') }}
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
                                        <div class="mb-2 form-check-lg form-switch">
                                            <input class="form-check-input form-checked-danger" value="Walk In Customer"
                                                type="checkbox" role="switch" name="param[]" id="chk-walk-in-customer">
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
                                                type="checkbox" role="switch" name="param[]" id="chk-by-invitation">
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
                                                name="param[]" id="chk-by-social-media-campaign">
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
                                                type="checkbox" role="switch" name="param[]" id="chk-by-buy-back">
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
                                                type="checkbox" role="switch" name="param[]" id="chk-reparation">
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
                                                type="checkbox" role="switch" name="param[]" id="chk-others">
                                            <label class="form-check-label" for="chk-others">{{ __('Others') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 mb-3" id="div-keterangan" style="display: none">
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            name="keterangan" id="keterangan" value="{{ old('keterangan') }}"
                                            placeholder="{{ __('Keterangan Others') }}">
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
            //
        });
    </script>
@endpush
