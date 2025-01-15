@extends('layouts.master')

@section('page_title')
    {{ __('Dashboard') }}
@endsection

@section('section_header_title')
    {{ __('Dashboard') }}
@endsection

@section('section_header_breadcrumb')
    @parent
@endsection

@section('page_content')
    @can('dashboard gsa')
        <div class="row">
            <div class="col-xxl-6 col-sm-6">
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="fw-medium mb-1 text-muted">{{ __('Total Sales (Value)') }}</p>
                                    <h3 class="mb-0">Rp. 1.000.000.000</h3>
                                </div>
                                <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
                                    <i class="bx bxs-badge-dollar fs-20"></i>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <span class="badge bg-primary-transparent rounded-pill">{{ __('Tahun') }}
                                    {{ activePeriod() }}
                                </span>
                                <a href="javascript:void(0);"
                                    class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ __('Lihat Detail') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6 col-sm-6">
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="fw-medium mb-1 text-muted">{{ __('Total Sales (Pcs)') }}</p>
                                    <h3 class="mb-0">2.000</h3>
                                </div>
                                <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
                                    <i class="bx bx-package fs-20"></i>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <span class="badge bg-warning-transparent rounded-pill">{{ __('Tahun') }}
                                    {{ activePeriod() }}
                                </span>
                                <a href="javascript:void(0);"
                                    class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ __('Lihat Detail') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card overflow-hidden">
                    <div class="row">
                        <div class="col-xl-12">
                            <br>
                            <div class="card-body p-0">
                                <div id="kreditstatistic1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div id="kreditstatistic2"></div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Penjualan Hari Ini') }}
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="row" class="fw-semibold ps-4">{{ __('Brand') }}</th>
                                        <th scope="row" class="fw-semibold">{{ __('Tipe Barang') }}</th>
                                        <th scope="row" class="fw-semibold">{{ __('Qty') }}</th>
                                        <th scope="row" class="fw-semibold">{{ __('Nominal') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="top-selling">
                                    @php
                                        $sum_qty = 0;
                                        $sum_nominal = 0;
                                    @endphp
                                    @if (count($penjualan_hari_ini) > 0)
                                        @foreach ($penjualan_hari_ini as $row)
                                            @php
                                                $sum_qty = $sum_qty + $row->qty;
                                                $sum_nominal = $sum_nominal + $row->nominal;
                                            @endphp
                                            <tr>
                                                <td class="ps-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <p class="mb-0">{{ $row->parameter_1 }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ $row->parameter_2 }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ formatAmount($row->qty) }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ formatAmount($row->nominal) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" align="center">
                                                <span class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="table-primary">
                                    <tr>
                                        <td class="ps-3" colspan="2">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2">
                                                    <p class="fw-semibold mb-0">{{ __('TOTAL') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold">{{ formatAmount($sum_qty) }}</td>
                                        <td class="fw-semibold">{{ formatAmount($sum_nominal) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Penjualan Bulan Ini') }}
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="row" class="fw-semibold ps-4">{{ __('Brand') }}</th>
                                        <th scope="row" class="fw-semibold">{{ __('Tipe Barang') }}</th>
                                        <th scope="row" class="fw-semibold">{{ __('Qty') }}</th>
                                        <th scope="row" class="fw-semibold">{{ __('Nominal') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="top-selling">
                                    @php
                                        $sum_qty = 0;
                                        $sum_nominal = 0;
                                    @endphp
                                    @if (count($penjualan_bulan_ini) > 0)
                                        @foreach ($penjualan_bulan_ini as $row)
                                            @php
                                                $sum_qty = $sum_qty + $row->qty;
                                                $sum_nominal = $sum_nominal + $row->nominal;
                                            @endphp
                                            <tr>
                                                <td class="ps-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <p class="mb-0">{{ $row->parameter_1 }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ $row->parameter_2 }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ formatAmount($row->qty) }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ formatAmount($row->nominal) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" align="center">
                                                <span class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="table-primary">
                                    <tr>
                                        <td class="ps-3" colspan="2">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2">
                                                    <p class="fw-semibold mb-0">{{ __('TOTAL') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold">{{ formatAmount($sum_qty) }}</td>
                                        <td class="fw-semibold">{{ formatAmount($sum_nominal) }}</td>
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
@endpush

@push('scripts')
    <script>
        var total_nilai_kredit_graph = {{ Js::from($total_nilai_kredit_graph) }};
        var total_nilai_pelunasan_graph = {{ Js::from($total_nilai_pelunasan_graph) }};
        var total_emas_graph = {{ Js::from($total_emas_graph) }};

        Highcharts.chart('kreditstatistic1', {
            chart: {
                type: 'column',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: 'Statistik Penjualan Barang (pcs)<br>{{ activePeriod() }}'
            },
            subtitle: {
                text: 'Source: <a href="https://www.goldmart.co.id/" target="_blank">goldmart<br><br><br></a>'
            },
            xAxis: {
                title: {
                    text: 'Tipe'
                },
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ]
            },
            yAxis: {
                title: {
                    text: 'Rupiah'
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
                name: 'Goldmart',
                data: [1, 20, 3, 4, 50, 1, 20, 3, 4, 50, 25, 42],
                lineWidth: 4
            }, {
                name: 'Goldmaster',
                data: [10, 50, 70, 40, 10, 9, 30, 56, 71, 25, 71, 25],
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
                type: 'line',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: 'Statistik Penjualan Barang (pcs)<br>{{ activePeriod() }}'
            },
            subtitle: {
                text: 'Source: <a href="https://www.goldmart.co.id/" target="_blank">goldmart<br><br><br></a>'
            },
            xAxis: {
                title: {
                    text: 'Tipe'
                },
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ]
            },
            yAxis: {
                title: {
                    text: 'Rupiah'
                }
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                    }
                },
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    animation: {
                        defer: 900
                    },
                    enableMouseTracking: true
                },
            },
            series: [{
                name: 'Goldmart',
                data: [1, 20, 3, 4, 50, 1, 20, 3, 4, 50, 25, 42],
                lineWidth: 4
            }, {
                name: 'Goldmaster',
                data: [10, 50, 70, 40, 10, 9, 30, 56, 71, 25, 71, 25],
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
    </script>
@endpush
