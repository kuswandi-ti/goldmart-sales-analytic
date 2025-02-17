@extends('layouts.master')

@section('page_title')
    {{ __('Laporan Kunjungan Detail') }}
@endsection

@section('section_header_title')
    {{ __('Laporan Kunjungan Detail') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <x-breadcrumb-active title="{{ __('Daftar Data Laporan Kunjungan Detail') }}" />
@endsection

@section('page_content')
    @if (canAccess(['laporan kunjungan detail']))
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Daftar Data Laporan Kunjungan Detail (Datang)') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data kunjungan detail (datang)') }}
                            </p>
                        </div>
                        <form action="{{ route('laporan.kunjungandetail') }}" method="GET" id="form-search-datang">
                            @csrf

                            <div class="dropdown d-flex mt-3">
                                <button type="submit"
                                    class="btn btn-sm btn-success btn-wave waves-effect waves-light d-flex align-items-center me-2"
                                    name="submit" value="export-datang">
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
                                        <td scope="col" align="right" class="fw-semibold">{{ __('By Buy Back') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('By Invitation') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">
                                            {{ __('By Social Media Campaign') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Others') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Reparation') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Walk In Customer') }}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data_table_datang) > 0)
                                        @foreach ($data_table_datang as $row)
                                            <tr>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->By_Buy_Back) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->By_Invitation) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->By_Social_Media_Campaign) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Others) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Reparation) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Walk_In_Customer) }}</span>
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
                            </table>
                        </div>

                        <br><br>

                        <div id="datangstatistic1"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Daftar Data Laporan Kunjungan Detail (Tanya)') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data kunjungan detail (tanya)') }}
                            </p>
                        </div>
                        <form action="{{ route('laporan.kunjungandetail') }}" method="GET" id="form-search-tanya">
                            @csrf

                            <div class="dropdown d-flex mt-3">
                                <button type="submit"
                                    class="btn btn-sm btn-success btn-wave waves-effect waves-light d-flex align-items-center me-2"
                                    name="submit" value="export-tanya">
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
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Barang') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Buy Back') }}
                                        </td>
                                        <td scope="col" align="right" class="fw-semibold">
                                            {{ __('Others') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Promo') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Range Harga') }}</td>
                                        <td scope="col" align="right" class="fw-semibold">{{ __('Reparasi') }}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data_table_tanya) > 0)
                                        @foreach ($data_table_tanya as $row)
                                            <tr>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Barang) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Buy_Back) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Others) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Promo) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Range_Harga) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span>{{ formatAmount($row->Reparasi) }}</span>
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
                            </table>
                        </div>

                        <br><br>

                        <div id="tanyastatistic1"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Daftar Data Laporan Kunjungan Detail (Coba)') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data kunjungan detail (coba)') }}
                            </p>
                        </div>
                        <form action="{{ route('laporan.kunjungandetail') }}" method="GET" id="form-search-coba">
                            @csrf

                            <div class="dropdown d-flex mt-3">
                                <button type="submit"
                                    class="btn btn-sm btn-success btn-wave waves-effect waves-light d-flex align-items-center me-2"
                                    name="submit" value="export-coba">
                                    {{ __('Export ke Excel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-striped table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <td scope="col" colspan="5" align="center" class="fw-semibold">
                                                    {{ __('GOLDMART') }}</td>
                                            </tr>
                                            <tr>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Bracelet') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Earring') }}
                                                </td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Necklace') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Pendant') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Ring') }}
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data_table_coba_goldmart) > 0)
                                                @foreach ($data_table_coba_goldmart as $row)
                                                    <tr>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Bracelet) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Earring) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Necklace) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Pendant) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Ring) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" align="center">
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-striped table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <td scope="col" colspan="10" align="center" class="fw-semibold">
                                                    {{ __('GOLDMASTER') }}</td>
                                            </tr>
                                            <tr>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Bangle') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Bracelet') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Brooch') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Charm') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Collier') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Earring') }}
                                                </td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Necklace') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Pendant') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Ring') }}
                                                </td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Tietack') }}
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data_table_coba_goldmaster) > 0)
                                                @foreach ($data_table_coba_goldmaster as $row)
                                                    <tr>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Bangle) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Bracelet) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Brooch) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Charm) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Collier) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Earring) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Necklace) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Pendant) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Ring) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Tietack) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="10" align="center">
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <br><br>

                        <div class="row">
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                <div id="cobagoldmartstatistic1"></div>
                            </div>
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                                <div id="cobagoldmasterstatistic1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Daftar Data Laporan Kunjungan Detail (Beli)') }}
                            <p class="subtitle text-muted fs-12 fw-normal">
                                {{ __('Menampilkan semua data kunjungan detail (beli)') }}
                            </p>
                        </div>
                        <form action="{{ route('laporan.kunjungandetail') }}" method="GET" id="form-search-beli">
                            @csrf

                            <div class="dropdown d-flex mt-3">
                                <button type="submit"
                                    class="btn btn-sm btn-success btn-wave waves-effect waves-light d-flex align-items-center me-2"
                                    name="submit" value="export-beli">
                                    {{ __('Export ke Excel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-striped table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <td scope="col" colspan="5" align="center" class="fw-semibold">
                                                    {{ __('GOLDMART') }}</td>
                                            </tr>
                                            <tr>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Bracelet') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Earring') }}
                                                </td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Necklace') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Pendant') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Ring') }}
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data_table_beli_goldmart) > 0)
                                                @foreach ($data_table_beli_goldmart as $row)
                                                    <tr>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Bracelet) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Earring) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Necklace) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Pendant) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Ring) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" align="center">
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-striped table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <td scope="col" colspan="10" align="center" class="fw-semibold">
                                                    {{ __('GOLDMASTER') }}</td>
                                            </tr>
                                            <tr>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Bangle') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Bracelet') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Brooch') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Charm') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Collier') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Earring') }}
                                                </td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Necklace') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Pendant') }}</td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Ring') }}
                                                </td>
                                                <td scope="col" align="right" class="fw-semibold">
                                                    {{ __('Tietack') }}
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data_table_beli_goldmaster) > 0)
                                                @foreach ($data_table_beli_goldmaster as $row)
                                                    <tr>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Bangle) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Bracelet) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Brooch) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Charm) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Collier) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Earring) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Necklace) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Pendant) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Ring) }}</span>
                                                        </td>
                                                        <td align="right">
                                                            <span>{{ formatAmount($row->Tietack) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="10" align="center">
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <br><br>

                        <div class="row">
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                <div id="beligoldmartstatistic1"></div>
                            </div>
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                                <div id="beligoldmasterstatistic1"></div>
                            </div>
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
        var data_datang_graph = {{ Js::from($data_datang_graph) }};
        var data_tanya_graph = {{ Js::from($data_tanya_graph) }};
        var data_coba_goldmart_graph = {{ Js::from($data_coba_goldmart_graph) }};
        var data_coba_goldmaster_graph = {{ Js::from($data_coba_goldmaster_graph) }};
        var data_beli_goldmart_graph = {{ Js::from($data_beli_goldmart_graph) }};
        var data_beli_goldmaster_graph = {{ Js::from($data_beli_goldmaster_graph) }};

        Highcharts.chart('datangstatistic1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Kunjungan (Datang)'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['By Buy Back', 'By Invitation', 'By Social Media Campaign', 'Others', 'Reparation',
                    'Walk In Customer'
                ],
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    },
                },
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Datang',
                data: data_datang_graph,
                lineWidth: 4
            }],
        });

        Highcharts.chart('tanyastatistic1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Kunjungan (Tanya)'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Barang', 'Buy Back', 'Others', 'Promo', 'Range Harga',
                    'Reparasi'
                ],
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    },
                },
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Tanya',
                data: data_tanya_graph,
                lineWidth: 4
            }],
        });

        Highcharts.chart('cobagoldmartstatistic1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Kunjungan (Coba)'
            },
            subtitle: {
                text: 'Goldmart'
            },
            xAxis: {
                categories: ['Bracelet', 'Earring', 'Necklace', 'Pendant', 'Ring'],
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    },
                },
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Coba - Goldmart',
                data: data_coba_goldmart_graph,
                lineWidth: 4
            }],
        });

        Highcharts.chart('cobagoldmasterstatistic1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Kunjungan (Coba)'
            },
            subtitle: {
                text: 'Goldmaster'
            },
            xAxis: {
                categories: ['Bangle', 'Bracelet', 'Brooch', 'Charm', 'Collier', 'Earring', 'Necklace', 'Pendant',
                    'Ring', 'Tietack'
                ],
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    },
                },
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Coba - Goldmaster',
                data: data_coba_goldmaster_graph,
                lineWidth: 4
            }],
        });

        Highcharts.chart('beligoldmartstatistic1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Kunjungan (Beli)'
            },
            subtitle: {
                text: 'Goldmart'
            },
            xAxis: {
                categories: ['Bracelet', 'Earring', 'Necklace', 'Pendant', 'Ring'],
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    },
                },
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Beli - Goldmart',
                data: data_beli_goldmart_graph,
                lineWidth: 4
            }],
        });

        Highcharts.chart('beligoldmasterstatistic1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Kunjungan (Beli)'
            },
            subtitle: {
                text: 'Goldmaster'
            },
            xAxis: {
                categories: ['Bangle', 'Bracelet', 'Brooch', 'Charm', 'Collier', 'Earring', 'Necklace', 'Pendant',
                    'Ring', 'Tietack'
                ],
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    },
                },
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Beli - Goldmaster',
                data: data_beli_goldmaster_graph,
                lineWidth: 4
            }],
        });
    </script>
@endpush
