@extends('layouts.master')

@section('page_title')
    {{ __('Permission') }}
@endsection

@section('section_header_title')
    {{ __('Permission') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Data Permission') }}</li> --}}
    <x-breadcrumb-active title="{{ __('Daftar Data Permission') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                    <div class="flex-fill">
                        <div class="card-title">
                            {{ __('Daftar Data Permission') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data permission akses user') }}
                            </p>
                        </div>
                    </div>
                    @can('permission create')
                        <div class="d-flex" role="search">
                            <a href="{{ route('permission.create') }}" class="btn btn-primary">
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
                                    <th scope="col" width="5%">{{ __('Aksi') }}</th>
                                    <th scope="col">{{ __('Nama Permission') }}</th>
                                    <th scope="col">{{ __('Grup Permission') }}</th>
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
                url: '{{ route('permission.data') }}',
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
                data: 'name',
                searchable: true,
                sortable: true,
            }, {
                data: 'group_name',
                searchable: true,
                sortable: true,
            }],
            "aaSorting": [
                [3, 'asc'],
                [2, 'asc']
            ],
        });
    </script>
@endpush
