@extends('layouts.master')

@section('page_title')
    {{ __('Detail Data Kredit Nasabah') }}
@endsection

@section('section_header_title')
    {{ __('Detail Data Kredit Nasabah') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Detail Data Kredit Nasabah') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                    <div class="flex-fill">
                        <div class="card-title">
                            {{ __('Daftar Detail Data Kredit Nasabah') }} - {{ $text }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua detail data kredit nasabah') }} - {{ $text }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-warning">
                            {{ __('Kembali') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table_data">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">{{ __('Nomor') }}</th>
                                    <th scope="col">{{ __('Nama Nasabah') }}</th>
                                    <th scope="col">{{ __('Nama Barang') }}</th>
                                    <th scope="col">{{ __('Jumlah Barang') }}</th>
                                    <th scope="col">{{ __('Total Nilai Kredit') }}</th>
                                    <th scope="col">{{ __('Margin Keuntungan') }}</th>
                                    <th scope="col">{{ __('Angsuran') }}</th>
                                    <th scope="col">{{ __('Tenor') }}</th>
                                    <th scope="col">{{ __('Tgl Pelunasan') }}</th>
                                    <th scope="col">{{ __('Tgl Kirim Barang') }}</th>
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
                url: 'detail_data/{{ $filter }}',
            },
            columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                sortable: false,
            }, {
                data: 'nama_nasabah',
                searchable: true,
                sortable: true,
            }, {
                data: 'nama_barang',
                searchable: true,
                sortable: true,
            }, {
                data: 'qty',
                searchable: true,
                sortable: true,
            }, {
                data: 'total_nilai_kredit',
                searchable: true,
                sortable: true,
            }, {
                data: 'margin_keuntungan',
                searchable: true,
                sortable: true,
            }, {
                data: 'angsuran',
                searchable: true,
                sortable: true,
            }, {
                data: 'tenor',
                searchable: true,
                sortable: true,
            }, {
                data: 'tgl_lunas',
                searchable: true,
                sortable: true,
            }, {
                data: 'tgl_kirim_barang',
                searchable: true,
                sortable: true,
            }],
            "columnDefs": [{
                "render": function(data, type, row) {
                    return formatAmount(data);
                },
                "targets": [4, 5, 6]
            }, ]
        });
    </script>
@endpush
