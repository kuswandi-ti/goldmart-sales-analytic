@extends('layouts.master')

@section('page_title')
    {{ __('Range Harga') }}
@endsection

@section('section_header_title')
    {{ __('Range Harga') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Data Range Harga') }}</li> --}}
    <x-breadcrumb-active title="{{ __('Daftar Data Range Harga') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                    <div class="flex-fill">
                        <div class="card-title">
                            {{ __('Daftar Data Range Harga') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data range harga') }}
                            </p>
                        </div>
                    </div>
                    @can('range harga create')
                        <div class="d-flex" role="search">
                            <a href="{{ route('rangeharga.create') }}" class="btn btn-primary">
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
                                    <th scope="col">{{ __('Deskripsi') }}</th>
                                    <th scope="col">{{ __('Harga Min.') }}</th>
                                    <th scope="col">{{ __('Harga Max.') }}</th>
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
                url: '{{ route('rangeharga.data') }}',
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
                data: 'nama',
                searchable: true,
                sortable: true,
            }, {
                data: 'harga_min',
                searchable: true,
                sortable: true,
            }, {
                data: 'harga_max',
                searchable: true,
                sortable: true,
            }],
            'columnDefs': [{
                'render': function(data, type, row) {
                    return formatAmount(data);
                },
                'targets': [3, 4]
            }],
            order: [
                [2, 'asc']
            ]
        });
    </script>
@endpush
