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
    <x-web-alert-message />

    <div class="row">
        <div class="col-xl-12">
            <div class="row row-cols-xxl-5 row-cols-xl-3 row-cols-md-2">
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="mb-1 fw-medium text-muted">Total Nasabah (orang)</p>
                                    <h4 class="mb-0">{{ $total_nasabah->total_nasabah }}</h4>
                                </div>
                                <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
                                    <i class='bx bxs-user-circle fs-20'></i>
                                </div>
                            </div>
                            <div class="mt-2 d-flex">
                                <a href="{{ route('nasabah.index') }}"
                                    class="mt-auto text-muted fs-11 ms-auto text-decoration-underline">Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="mb-1 fw-medium text-muted">Total Nilai Kredit (Rp.)</p>
                                    <h4 class="mb-0">{{ formatAmount($total_nilai_kredit->total_nilai_kredit) }}</h4>
                                </div>
                                <div class="avatar avatar-md br-4 bg-secondary-transparent ms-auto">
                                    <i class='bx bx-credit-card fs-20'></i>
                                </div>
                            </div>
                            <div class="mt-2 d-flex">
                                <a href="kreditnasabah/detail/kredit"
                                    class="mt-auto text-muted fs-11 ms-auto text-decoration-underline">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="mb-1 fw-medium text-muted">Total Keuntungan (Rp.)</p>
                                    <h4 class="mb-0">{{ formatAmount($total_margin_keuntungan->total_margin_keuntungan) }}
                                    </h4>
                                </div>
                                <div class="avatar avatar-md br-4 bg-info-transparent ms-auto">
                                    <i class='bx bxs-wallet fs-20'></i>
                                </div>
                            </div>
                            <div class="mt-2 d-flex">
                                <a href="kreditnasabah/detail/keuntungan"
                                    class="mt-auto text-muted fs-11 ms-auto text-decoration-underline">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="mb-1 fw-medium text-muted">Sudah Pelunasan (Rp.)</p>
                                    <h4 class="mb-0">{{ formatAmount($total_sudah_lunas->total_pelunasan) }}</h4>
                                </div>
                                <div class="avatar avatar-md br-4 bg-warning-transparent ms-auto">
                                    <i class="bi bi-currency-dollar fs-20"></i>
                                </div>
                            </div>
                            <div class="mt-2 d-flex">
                                <a href="kreditnasabah/detail/sudah-lunas"
                                    class="mt-auto text-muted fs-11 ms-auto text-decoration-underline">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="mb-1 fw-medium text-muted">Belum Pelunasan (Rp.)</p>
                                    <h4 class="mb-0">{{ formatAmount($total_belum_lunas->total_belum_lunas) }}</h4>
                                </div>
                                <div class="avatar avatar-md br-4 bg-danger-transparent ms-auto">
                                    <i class="bi bi-bell fs-20"></i>
                                </div>
                            </div>
                            <div class="mt-2 d-flex">
                                <a href="kreditnasabah/detail/belum-lunas"
                                    class="mt-auto text-muted fs-11 ms-auto text-decoration-underline">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card">
                <div class="card-header  justify-content-between">
                    <div class="card-title">Statistik Pelunasan Kredit</div>
                </div>
                <div class="card-body">
                    <div id="kreditstatistic1"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card">
                <div class="card-header  justify-content-between">
                    <div class="card-title">Statistik Pelunasan Kredit</div>
                </div>
                <div class="card-body">
                    <div id="kreditstatistic2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_vendor')
    <script src="{{ asset(config('common.path_template') . 'assets/libs/highcharts/highcharts.js') }}"></script>
@endpush

@push('scripts')
    <script>
        var total_nilai_kredit_graph = {{ Js::from($total_nilai_kredit_graph) }};
        var total_nilai_pelunasan_graph = {{ Js::from($total_nilai_pelunasan_graph) }};

        Highcharts.chart('kreditstatistic1', {
            chart: {
                type: 'line',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: 'Statistik Pelunasan Kredit, tahun {{ activePeriod() }}'
            },
            subtitle: {
                text: 'Source: <a href="https://www.goldmart.co.id/" target="_blank">goldmart</a>'
            },
            xAxis: {
                title: {
                    text: 'Bulan'
                },
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December'
                ]
            },
            yAxis: {
                title: {
                    text: 'Rupiah'
                }
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    label: {
                        connectorAllowed: false
                    },
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
                name: 'Total Kredit',
                data: total_nilai_kredit_graph,
                lineWidth: 4
            }, {
                name: 'Total Pelunasan',
                data: total_nilai_pelunasan_graph,
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
                text: 'Statistik Pelunasan Kredit, tahun {{ $setting_system['tahun_periode_aktif'] }}'
            },
            subtitle: {
                text: 'Source: <a href="https://www.goldmart.co.id/" target="_blank">goldmart</a>'
            },
            xAxis: {
                title: {
                    text: 'Bulan'
                },
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December'
                ]
            },
            yAxis: {
                title: {
                    text: 'Rupiah'
                }
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true
                    }
                },
                column: {
                    animation: {
                        defer: 900
                    }
                },
            },
            series: [{
                name: 'Total Kredit',
                data: total_nilai_kredit_graph
            }, {
                name: 'Total Pelunasan',
                data: total_nilai_pelunasan_graph
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
