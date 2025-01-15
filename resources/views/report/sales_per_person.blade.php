@extends('layouts.master')

@section('page_title')
    {{ __('Report Sales per Person') }}
@endsection

@section('section_header_title')
    {{ __('Report Sales per Person') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">{{ __('Daftar Data Report Sales per Person') }}</li>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                    <div class="flex-fill">
                        <div class="card-title">
                            {{ __('Daftar Data Report Sales per Person') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data sales per person') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">{{ __('No.') }}</th>
                                    <th scope="col">{{ __('Sales Person') }}</th>
                                    <th scope="col">{{ __('Total (Pcs)') }}</th>
                                    <th scope="col">{{ __('Total (Value)') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="lh-1">
                                                    <span>Sales 1</span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="fs-11 text-muted">sales1@gmail.com</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>123</td>
                                    <td>50.000.000</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="lh-1">
                                                    <span>Sales 2</span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="fs-11 text-muted">sales2@gmail.in</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>123</td>
                                    <td>50.000.000</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="lh-1">
                                                    <span>Sales 3</span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="fs-11 text-muted">sales3@gmail.com</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>123</td>
                                    <td>50.000.000</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="lh-1">
                                                    <span>Sales 4</span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="fs-11 text-muted">sales4@gmail.com</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>123</td>
                                    <td>50.000.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <br><br><br>

                    <div id="kreditstatistic1"></div>
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
        Highcharts.chart('kreditstatistic1', {
            chart: {
                type: 'column',
                zooming: {
                    type: 'x'
                }
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
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
    </script>
@endpush
