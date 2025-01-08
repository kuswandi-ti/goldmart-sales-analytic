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
        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div id="kreditstatistic1"></div>
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
                type: 'line',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: 'Statistik Pelunasan Kredit<br>{{ activePeriod() }}'
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
                text: 'Statistik Total Emas (Belum Pelunasan)<br>{{ $setting_system['tahun_periode_aktif'] }}'
            },
            subtitle: {
                text: 'Source: <a href="https://www.goldmart.co.id/" target="_blank">goldmart</a>'
            },
            xAxis: {
                title: {
                    text: 'Gramasi'
                },
                categories: ['0,5', '1', '2', '3', '5', '10', '25', '50', '100']
            },
            yAxis: {
                title: {
                    text: 'Jumlah'
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
                name: 'Total Emas',
                data: total_emas_graph
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
