@extends('layouts.master')

@section('page_title')
    {{ __('Laporan Penjualan per Person') }}
@endsection

@section('section_header_title')
    {{ __('Laporan Penjualan per Person') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Data Laporan Penjualan per Person') }}</li> --}}
    <x-breadcrumb-active title="{{ __('Daftar Data Laporan Penjualan per Person') }}" />
@endsection

@section('page_content')
    @if (canAccess(['laporan penjualan per person']))
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Daftar Data Laporan Penjualan per Person') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data penjualan per person') }}
                            </p>
                        </div>
                        <form action="{{ route('laporan.penjualanperperson') }}" method="GET" id="form-search">
                            @csrf

                            <div class="dropdown d-flex mt-3">
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
                                        <td scope="col" class="fw-semibold">{{ __('Sales Person') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Nama Store') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Kota Store') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Total (Qty)') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Total (Rp.)') }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 0;
                                        $sum_qty = 0;
                                        $sum_nominal = 0;
                                    @endphp
                                    @if (count($data_table) > 0)
                                        @foreach ($data_table as $row)
                                            @php
                                                $no = $no + 1;
                                                $sum_qty = $sum_qty + $row->total_qty;
                                                $sum_nominal = $sum_nominal + $row->total_nominal;
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <span>{{ $no }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->nama_sales_person }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->nama_store }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->kota_store }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->total_qty) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->total_nominal) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" align="center">
                                                <span class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="table-primary">
                                    <tr>
                                        <td colspan="4">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="fw-semibold mb-0">{{ __('TOTAL') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_qty) }}</td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_nominal) }}</td>
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
                        <div id="kreditstatistic1"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div id="kreditstatistic2"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12">
                <div class="card border border-primary custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Total Penjualan') }} <span class="text-danger">{{ __('HARI') }}</span>
                            {{ __('ini (Per Person)') }}
                            @can('dashboard gsa')
                                {{ __('- All Store') }}
                            @endcan
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <td scope="col" class="fw-semibold">{{ __('Sales Person') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Nama Store') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Kota Store') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Qty') }}
                                        </td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Rp.') }}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody class="top-selling">
                                    @php
                                        $sum_qty = 0;
                                        $sum_nominal = 0;
                                    @endphp
                                    @if (count($penjualan_hari_ini_per_person) > 0)
                                        @foreach ($penjualan_hari_ini_per_person as $row)
                                            @php
                                                $sum_qty = $sum_qty + $row->qty;
                                                $sum_nominal = $sum_nominal + $row->nominal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span>{{ $row->nama_sales }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->nama_store }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->kota_store }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->qty) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->nominal) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">
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
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_qty) }}</td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_nominal) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12">
                <div class="card border border-primary custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Total Penjualan') }} <span class="text-danger">{{ __('BULAN') }}</span>
                            {{ __('ini (Per Person)') }}
                            @can('dashboard gsa')
                                {{ __('- All Store') }}
                            @endcan
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <td scope="col" class="fw-semibold">{{ __('Sales Person') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Nama Store') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Kota Store') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Qty') }}
                                        </td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Rp.') }}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody class="top-selling">
                                    @php
                                        $sum_qty = 0;
                                        $sum_nominal = 0;
                                    @endphp
                                    @if (count($penjualan_bulan_ini_per_person) > 0)
                                        @foreach ($penjualan_bulan_ini_per_person as $row)
                                            @php
                                                $sum_qty = $sum_qty + $row->qty;
                                                $sum_nominal = $sum_nominal + $row->nominal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span>{{ $row->nama_sales }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->nama_store }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->kota_store }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->qty) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->nominal) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">
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
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_qty) }}</td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_nominal) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12">
                <div class="card border border-primary custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Total Penjualan') }} <span class="text-danger">{{ __('TAHUN') }}</span>
                            {{ __('ini (Per Person)') }}
                            @can('dashboard gsa')
                                {{ __('- All Store') }}
                            @endcan
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <td scope="col" class="fw-semibold">{{ __('Sales Person') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Nama Store') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Kota Store') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Qty') }}
                                        </td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Rp.') }}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody class="top-selling">
                                    @php
                                        $sum_qty = 0;
                                        $sum_nominal = 0;
                                    @endphp
                                    @if (count($penjualan_tahun_ini_per_person) > 0)
                                        @foreach ($penjualan_tahun_ini_per_person as $row)
                                            @php
                                                $sum_qty = $sum_qty + $row->qty;
                                                $sum_nominal = $sum_nominal + $row->nominal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span>{{ $row->nama_sales }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->nama_store }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->kota_store }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->qty) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->nominal) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">
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
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_qty) }}</td>
                                        <td align="right" class="fw-semibold">{{ formatAmount($sum_nominal) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
        var data_sales_graph = {{ Js::from($data_sales_graph) }};
        var data_qty_graph = {{ Js::from($data_qty_graph) }};
        var data_nominal_graph = {{ Js::from($data_nominal_graph) }};

        var f = {{ Js::from(request()->get('f')) }}
        var e = '';

        if (f == 'all' || !f) {
            e = 'Semua Data';
        } else if (f == 'daily') {
            e = 'Tanggal ' + {{ Js::from(request()->get('efd')) }};
        } else if (f == 'weekly') {
            e = 'Minggu ke ' + {{ Js::from(request()->get('efw')) }};
        } else if (f == 'monthly') {
            e = 'Bulan ' + months[{{ Js::from(request()->get('efm')) }} - 1];
        } else if (f == 'quarterly') {
            e = 'Quarter ke ' + {{ Js::from(request()->get('efq')) }};
        } else if (f == 'yearly') {
            e = 'Tahun ' + {{ Js::from(request()->get('efy')) }};
        }

        Highcharts.chart('kreditstatistic1', {
            chart: {
                type: 'column',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: 'Grafik Penjualan per Person (Qty)'
            },
            subtitle: {
                text: e
            },
            xAxis: {
                title: {
                    text: 'Sales'
                },
                categories: data_sales_graph
            },
            yAxis: {
                title: {
                    text: 'Qty'
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
                name: 'Total Qty',
                data: data_qty_graph,
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

        Highcharts.chart('kreditstatistic2', {
            chart: {
                type: 'column',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: 'Grafik Penjualan per Person (Rp.)'
            },
            subtitle: {
                text: e
            },
            xAxis: {
                title: {
                    text: 'Sales'
                },
                categories: data_sales_graph
            },
            yAxis: {
                title: {
                    text: 'Rp.'
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
                name: 'Total Nominal',
                data: data_nominal_graph,
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
