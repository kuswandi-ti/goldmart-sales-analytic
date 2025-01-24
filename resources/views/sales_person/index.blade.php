@extends('layouts.master')

@section('page_title')
    {{ __('Sales Person') }}
@endsection

@section('section_header_title')
    {{ __('Sales Person') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Data Sales Person') }}</li> --}}
    <x-breadcrumb-active title="{{ __('Daftar Data Sales Person') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                    <div class="flex-fill">
                        <div class="card-title">
                            {{ __('Daftar Data Sales Person') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data sales person') }}
                            </p>
                        </div>
                    </div>
                    @can('sales person create')
                        <div class="d-flex" role="search">
                            <a href="{{ route('salesperson.create') }}" class="btn btn-primary">
                                {{ __('Baru') }}
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table_data">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">{{ __('Nomor') }}</th>
                                    <th scope="col" width="12%">{{ __('Aksi') }}</th>
                                    <th scope="col">{{ __('Kode Sales') }}</th>
                                    <th scope="col">{{ __('Nama Sales') }}</th>
                                    <th scope="col">{{ __('NIK') }}</th>
                                    <th scope="col">{{ __('Store') }}</th>
                                    <th scope="col">{{ __('Kota') }}</th>
                                    <th scope="col" width="10%">{{ __('Status Aktif') }}</th>
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
                url: '{{ route('salesperson.data') }}',
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
                data: 'nik',
                searchable: true,
                sortable: true,
            }, {
                data: 'nama_store',
                searchable: true,
                sortable: true,
            }, {
                data: 'kota_store',
                searchable: true,
                sortable: true,
            }, {
                data: 'status_aktif',
                searchable: true,
                sortable: true,
            }],
        });
    </script>
@endpush
