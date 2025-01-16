@extends('layouts.master')

@section('page_title')
    {{ __('Report Sales per Store') }}
@endsection

@section('section_header_title')
    {{ __('Report Sales per Store') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Data Report Sales per Store') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="card-header  justify-content-between">
                    <div class="card-title">
                        {{ __('Daftar Data Report Sales per Store') }}
                        <p class="subtitle text-muted fs-12 fw-normal">
                            {{ __('Menampilkan semua data sales per store') }}
                        </p>
                    </div>
                    <form action="{{ route('report.salesperstore') }}" method="GET" id="form-search">
                        @csrf

                        <div class="dropdown d-flex">
                            <button type="submit"
                                class="btn btn-sm btn-primary-light btn-wave waves-effect waves-light d-flex align-items-center me-2">
                                {{ __('Submit') }}
                            </button>

                            <input type="hidden" value="" id="main-filter" name="main_filter">

                            <div class="me-2" id="div-filter">
                                <div class="input-group" id="div-filter-daily" style="width: 200px; display: none;">
                                    <div class="input-group-text text-muted">
                                        <i class="ri-calendar-line"></i>
                                    </div>
                                    <input type="text" class="form-control flatpickr" name="elem_filter_daily"
                                        value="{{ old('filter_daily') ?? date('Y-m-d') }}">
                                </div>
                                <div id="div-filter-weekly" style="width: 100px; display: none;">
                                    @php
                                        echo "<select class='js-example-placeholder-single js-states form-control select2' name='elem_filter_weekly'>";
                                        for ($i = 1; $i <= 53; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        echo '</select>';
                                    @endphp
                                </div>
                                <div id="div-filter-monthly" style="width: 200px; display: none;">
                                    @php
                                        echo "<select class='js-example-placeholder-single js-states form-control select2' name='elem_filter_monthly'>";
                                        for ($i = 1; $i <= 12; $i++) {
                                            echo "<option value='$i'>" . formatMonth($i) . '</option>';
                                        }
                                        echo '</select>';
                                    @endphp
                                </div>
                                <div id="div-filter-quarterly" style="width: 100px; display: none;">
                                    @php
                                        echo "<select class='js-example-placeholder-single js-states form-control select2' name='elem_filter_quarterly'>";
                                        for ($i = 1; $i <= 4; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        echo '</select>';
                                    @endphp
                                </div>
                                <div id="div-filter-yearly" style="width: 100px; display: none;">
                                    <input type="text" class="form-control" name="elem_filter_yearly"
                                        value="{{ old('filter_yearly') ?? activePeriod() }}">
                                </div>
                            </div>
                            <a href="javascript:void(0);"
                                class="btn dropdown-toggle btn-sm btn-wave waves-effect waves-light btn-primary d-flex align-items-center"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-calendar-2-line me-1"></i>{{ __('Semua Data') }}
                            </a>
                            <ul class="dropdown-menu mb-0" role="menu">
                                <li class="border-bottom" id="filter-all">
                                    <a class="dropdown-item" href="javascript:void(0);">
                                        {{ __('Semua Data') }}
                                    </a>
                                </li>
                                <li class="border-bottom" id="li-filter-daily">
                                    <a class="dropdown-item {{ request()->get('main_filter') == 'daily' ? 'active' : '' }}"
                                        href="javascript:void(0);" id="filter-daily">
                                        {{ __('Daily') }}
                                    </a>
                                </li>
                                <li class="border-bottom" id="li-filter-weekly">
                                    <a class="dropdown-item" href="javascript:void(0);" id="filter-weekly">
                                        {{ __('Weekly') }}
                                    </a>
                                </li>
                                <li class="border-bottom" id="li-filter-monthly">
                                    <a class="dropdown-item" href="javascript:void(0);" id="filter-monthly">
                                        {{ __('Monthly') }}
                                    </a>
                                </li>
                                <li class="border-bottom" id="li-filter-quarterly">
                                    <a class="dropdown-item" href="javascript:void(0);" id="filter-quarterly">
                                        {{ __('Quarterly') }}
                                    </a>
                                </li>
                                <li id="li-filter-yearly">
                                    <a class="dropdown-item" href="javascript:void(0);" id="filter-yearly">
                                        {{ __('Yearly') }}
                                    </a>
                                </li>
                            </ul>
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
        var data_store_graph = {{ Js::from($data_store_graph) }};
        var data_qty_graph = {{ Js::from($data_qty_graph) }};
        var data_nominal_graph = {{ Js::from($data_nominal_graph) }};

        Highcharts.chart('kreditstatistic1', {
            chart: {
                type: 'column',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: 'Statistik Penjualan per Store (Qty)'
            },
            subtitle: {
                text: 'Tahun {{ activePeriod() }}'
            },
            xAxis: {
                title: {
                    text: 'Store'
                },
                categories: data_store_graph
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
                text: 'Statistik Penjualan per Store (Rp.)'
            },
            subtitle: {
                text: 'Tahun {{ activePeriod() }}'
            },
            xAxis: {
                title: {
                    text: 'Store'
                },
                categories: data_store_graph
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

        });
    </script>
@endpush
