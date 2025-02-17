@extends('layouts.master')

@section('page_title')
    {{ __('Customer Visit') }}
@endsection

@section('section_header_title')
    {{ __('Customer Visit') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Data Customer Visit') }}</li> --}}
    <x-breadcrumb-active title="{{ __('Daftar Data Customer Visit') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                    <div class="flex-fill">
                        <div class="card-title">
                            {{ __('Daftar Data Customer Visit') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data customer visit') }}
                            </p>
                        </div>
                    </div>
                    @can('customer visit create')
                        <div class="d-flex" role="search">
                            {{-- <a href="{{ route('customervisit.input') }}" class="btn btn-primary">
                                {{ __('Baru') }}
                            </a> --}}
                            <a href="{{ route('customervisit.create') }}" class="btn btn-primary">
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
                                    <th scope="col">{{ __('No Dokumen Visit') }}</th>
                                    <th scope="col">{{ __('Tgl Visit') }}</th>
                                    {{-- <th scope="col">{{ __('Parameter') }}</th> --}}
                                    <th scope="col">{{ __('Sales Person') }}</th>
                                    <th scope="col">{{ __('Store') }}</th>
                                    <th scope="col">{{ __('Kota') }}</th>
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
                url: '{{ route('customervisit.data') }}',
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
                data: 'no_dokumen',
                searchable: true,
                sortable: true,
            }, {
                data: 'tgl_visit',
                searchable: true,
                sortable: true,
                // }, {
                //     data: 'parameter_1',
                //     searchable: true,
                //     sortable: true,
            }, {
                data: 'nama_sales',
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
            }],
            order: [
                [3, 'desc']
            ]
        });
    </script>
@endpush
