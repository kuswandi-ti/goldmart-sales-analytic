@extends('layouts.master')

@section('page_title')
    {{ __('Laporan Kunjungan per Store') }}
@endsection

@section('section_header_title')
    {{ __('Laporan Kunjungan per Store') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <x-breadcrumb-active title="{{ __('Daftar Data Laporan Kunjungan per Store') }}" />
@endsection

@section('page_content')
    @if (canAccess(['laporan kunjungan per store']))
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Daftar Data Laporan Kunjungan per Store') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data kunjungan per store') }}
                            </p>
                        </div>
                        <form action="{{ route('laporan.kunjunganperstore') }}" method="GET" id="form-search">
                            @csrf

                            <div class="dropdown d-flex mt-3">
                                <div class="me-2" style="width: 250px;">
                                    <select class="js-example-placeholder-single js-states form-control select2"
                                        name="kota" id="kota">
                                        <option value="all-kota" {{ request()->get('s') == 'all-kota' ? 'selected' : '' }}
                                            id="filter-all-kota">{{ __('Semua Kota') }}</option>
                                        @foreach ($kota as $data)
                                            <option value="{{ $data->nama }}"
                                                {{ request()->get('kota') == $data->nama ? 'selected' : '' }}>
                                                {{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="me-2" id="div-filter">
                                    <div class="input-group" id="div-filter-daily"
                                        style="width: 200px; display: {{ request()->get('f') == 'daily' ? '' : 'none' }};">
                                        <div class="input-group-text text-muted">
                                            <i class="ri-calendar-line"></i>
                                        </div>
                                        <input type="text" class="form-control flatpickr" name="efd"
                                            value="{{ request()->get('f') == 'daily' ? request()->get('efd') : date('Y-m-d') }}">
                                    </div>
                                    <div id="div-filter-weekly"
                                        style="width: 100px; display: {{ request()->get('f') == 'weekly' ? '' : 'none' }};">
                                        <select class='js-example-placeholder-single js-states form-control select2'
                                            name='efw'>
                                            @for ($i = 1; $i <= 53; $i++)
                                                <option value={{ $i }}
                                                    {{ request()->get('efw') == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div id="div-filter-monthly"
                                        style="width: 200px; display: {{ request()->get('f') == 'monthly' ? '' : 'none' }};">
                                        <select class='js-example-placeholder-single js-states form-control select2'
                                            name='efm'>
                                            @for ($i = 1; $i < 12; $i++)
                                                <option value={{ $i }}
                                                    {{ request()->get('efm') == $i ? 'selected' : '' }}>
                                                    {{ formatMonth($i) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div id="div-filter-quarterly"
                                        style="width: 100px; display: {{ request()->get('f') == 'quarterly' ? '' : 'none' }};">
                                        <select class='js-example-placeholder-single js-states form-control select2'
                                            name='efq'>
                                            @for ($i = 1; $i <= 4; $i++)
                                                <option value={{ $i }}
                                                    {{ request()->get('efq') == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div id="div-filter-yearly"
                                        style="width: 100px; display: {{ request()->get('f') == 'yearly' ? '' : 'none' }};">
                                        <input type="text" class="form-control" name="efy"
                                            value="{{ request()->get('f') == 'yearly' ? request()->get('efy') : activePeriod() }}">
                                    </div>
                                </div>

                                <div class="me-2" style="width: 150px;">
                                    <select class = "form-select" name='f' style="height: 100%;">
                                        <option value="all" {{ request()->get('f') == 'all' ? 'selected' : '' }}
                                            id="filter-all">{{ __('Semua Data') }}</option>
                                        <option value="daily" {{ request()->get('f') == 'daily' ? 'selected' : '' }}
                                            id="filter-daily">{{ __('Daily') }}</option>
                                        <option value="weekly" {{ request()->get('f') == 'weekly' ? 'selected' : '' }}
                                            id="filter-weekly">{{ __('Weekly') }}</option>
                                        <option value="monthly" {{ request()->get('f') == 'monthly' ? 'selected' : '' }}
                                            id="filter-monthly">{{ __('Monthly') }}</option>
                                        <option value="quarterly"
                                            {{ request()->get('f') == 'quarterly' ? 'selected' : '' }}
                                            id="filter-quarterly">{{ __('Quarterly') }}</option>
                                        <option value="yearly" {{ request()->get('f') == 'yearly' ? 'selected' : '' }}
                                            id="filter-yearly">{{ __('Yearly') }}</option>
                                    </select>
                                </div>

                                <button type="submit"
                                    class="btn btn-sm btn-primary-light btn-wave waves-effect waves-light d-flex align-items-center me-2"
                                    name="submit" value="search">
                                    {{ __('Submit') }}
                                </button>
                                <button type="submit"
                                    class="btn btn-sm btn-success btn-wave waves-effect waves-light d-flex align-items-center me-2"
                                    name="submit" value="export">
                                    {{ __('Export ke Excel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <td scope="col" class="text-center fw-semibold">{{ __('No.') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Nama Store') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Kota Store') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Datang') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Tanya') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Coba') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Beli') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('%Coba-Beli') }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 0;
                                        $sum_datang = 0;
                                        $sum_tanya = 0;
                                        $sum_coba = 0;
                                        $sum_beli = 0;
                                    @endphp
                                    @if (count($data_table) > 0)
                                        @foreach ($data_table as $row)
                                            @php
                                                $no = $no + 1;
                                                $sum_datang = $sum_datang + $row->datang;
                                                $sum_tanya = $sum_tanya + $row->tanya;
                                                $sum_coba = $sum_coba + $row->coba;
                                                $sum_beli = $sum_beli + $row->beli;
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <span>{{ $no }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->nama_store }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->kota_store }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->datang) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->tanya) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->coba) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->beli) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->persentase) }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" align="center">
                                                <span class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="table-primary">
                                    <tr>
                                        <td colspan="3">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="fw-semibold mb-0">{{ __('TOTAL') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_datang) }}</td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_tanya) }}</td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_coba) }}</td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_beli) }}</td>
                                        <td align="right" class="fw-semibold">&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div id="kunjunganstatistic1"></div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('scripts_vendor')
    <script src="{{ asset(config('common.path_template') . 'assets/libs/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset(config('common.path_template') . 'assets/libs/highcharts/exporting.js') }}"></script>
    <script src="{{ asset(config('common.path_template') . 'assets/libs/highcharts/offline-exporting.js') }}"></script>
@endpush

@include('layouts.includes.select2')
@include('layouts.includes.flatpickr')

@push('scripts')
    <script>
        var nama_kota = {{ Js::from($nama_kota) }};
        var data_store_graph = {{ Js::from($data_store_graph) }};
        var data_datang_graph = {{ Js::from($data_datang_graph) }};
        var data_tanya_graph = {{ Js::from($data_tanya_graph) }};
        var data_coba_graph = {{ Js::from($data_coba_graph) }};
        var data_beli_graph = {{ Js::from($data_beli_graph) }};

        var f = {{ Js::from(request()->get('f')) }}
        var e = '';

        if (f == 'all' || !f) {
            e = 'Semua Data, ' + nama_kota;
        } else if (f == 'daily') {
            e = 'Tanggal ' + {{ Js::from(request()->get('efd')) }} + ', ' + nama_kota;
        } else if (f == 'weekly') {
            e = 'Minggu ke ' + {{ Js::from(request()->get('efw')) }} + ', ' + nama_kota;
        } else if (f == 'monthly') {
            e = 'Bulan ' + months[{{ Js::from(request()->get('efm')) }} - 1] + ', ' + nama_kota;
        } else if (f == 'quarterly') {
            e = 'Quarter ke ' + {{ Js::from(request()->get('efq')) }} + ', ' + nama_kota;
        } else if (f == 'yearly') {
            e = 'Tahun ' + {{ Js::from(request()->get('efy')) }} + ', ' + nama_kota;
        }

        Highcharts.chart('kunjunganstatistic1', {
            chart: {
                type: 'column',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: 'Grafik Kunjungan per Store'
            },
            subtitle: {
                text: e
            },
            xAxis: {
                title: {
                    text: 'Store'
                },
                categories: data_store_graph
            },
            yAxis: {
                title: {
                    text: 'Total'
                }
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            series: [{
                name: 'Datang',
                data: data_datang_graph,
                lineWidth: 4
            }, {
                name: 'Tanya',
                data: data_tanya_graph,
                lineWidth: 4
            }, {
                name: 'Coba',
                data: data_coba_graph,
                lineWidth: 4
            }, {
                name: 'Beli',
                data: data_beli_graph,
                lineWidth: 4
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });

        $(document).ready(function() {
            $("#filter-all").click(function() {
                $("#div-filter").hide();
            });

            $("#filter-daily").click(function() {
                $("#div-filter").show();
                $("#div-filter-daily").show();
                $("#div-filter-weekly").hide();
                $("#div-filter-monthly").hide();
                $("#div-filter-quarterly").hide();
                $("#div-filter-yearly").hide();
            });

            $("#filter-weekly").click(function() {
                $("#div-filter").show();
                $("#div-filter-daily").hide();
                $("#div-filter-weekly").show();
                $("#div-filter-monthly").hide();
                $("#div-filter-quarterly").hide();
                $("#div-filter-yearly").hide();
            });

            $("#filter-monthly").click(function() {
                $("#div-filter").show();
                $("#div-filter-daily").hide();
                $("#div-filter-weekly").hide();
                $("#div-filter-monthly").show();
                $("#div-filter-quarterly").hide();
                $("#div-filter-yearly").hide();
            });

            $("#filter-quarterly").click(function() {
                $("#div-filter").show();
                $("#div-filter-daily").hide();
                $("#div-filter-weekly").hide();
                $("#div-filter-monthly").hide();
                $("#div-filter-quarterly").show();
                $("#div-filter-yearly").hide();
            });

            $("#filter-yearly").click(function() {
                $("#div-filter").show();
                $("#div-filter-daily").hide();
                $("#div-filter-weekly").hide();
                $("#div-filter-monthly").hide();
                $("#div-filter-quarterly").hide();
                $("#div-filter-yearly").show();
            });
        });
    </script>
@endpush
