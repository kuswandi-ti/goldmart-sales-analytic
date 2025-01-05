@extends('layouts.master')

@section('page_title')
    {{ __('Nasabah') }}
@endsection

@section('section_header_title')
    {{ __('Nasabah') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Data Nasabah') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                    <div class="flex-fill">
                        <div class="card-title">
                            {{ __('Daftar Data Nasabah') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data nasabah') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table_data">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">{{ __('Nomor') }}</th>
                                    <th scope="col" width="12%">{{ __('Aksi') }}</th>
                                    <th scope="col">{{ __('Kode Nasabah') }}</th>
                                    <th scope="col">{{ __('Nama Nasabah') }}</th>
                                    <th scope="col">{{ __('Alamat') }}</th>
                                    <th scope="col">{{ __('No. Telp') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<x-web-sweet-alert />

@include('layouts.includes.datatable')

@push('scripts')
    <script>
        let table_data;

        table_data = $('#table_data').DataTable({
            processing: true,
            autoWidth: false,
            responsive: true,
            serverSide: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            },
            ajax: {
                url: '{{ route('nasabah.data') }}',
            },
            columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                sortable: false,
            }, {
                data: 'action',
                searchable: false,
                sortable: false,
            }, {
                data: 'kode',
                searchable: true,
                sortable: true,
            }, {
                data: 'nama',
                searchable: true,
                sortable: true,
            }, {
                data: 'alamat',
                searchable: true,
                sortable: true,
            }, {
                data: 'no_tlp',
                searchable: true,
                sortable: true,
            }, {
                data: 'email',
                searchable: true,
                sortable: true,
            }],
        });
    </script>
@endpush
