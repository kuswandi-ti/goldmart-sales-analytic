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
    <div class="row">
        <div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12">
            <div class="col card-background">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <p class="fw-medium mb-1 text-muted">{{ __('Total Penjualan (Rp.)') }}</p>
                                <h4 class="mb-0">{{ formatAmount($total_sales_value->total_sales_value ?? 0) }}</h4>
                            </div>
                            <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
                                <i class="bx bxs-dollar-circle fs-20"></i>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <span class="badge bg-primary-transparent rounded-pill">{{ __('Tahun') }}
                                {{ activePeriod() }}
                            </span>
                            {{-- <a href="javascript:void(0);"
                                    class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ __('Lihat Detail') }}
                                </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12">
            <div class="col card-background">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <p class="fw-medium mb-1 text-muted">{{ __('Total Penjualan (Qty)') }}</p>
                                <h4 class="mb-0">{{ formatAmount($total_sales_pcs->total_sales_pcs ?? 0) }}</h4>
                            </div>
                            <div class="avatar avatar-md br-4 bg-warning-transparent ms-auto">
                                <i class="bx bx-package fs-20"></i>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <span class="badge bg-warning-transparent rounded-pill">{{ __('Tahun') }}
                                {{ activePeriod() }}
                            </span>
                            {{-- <a href="javascript:void(0);"
                                    class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ __('Lihat Detail') }}
                                </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12">
            <div class="col card-background">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <p class="fw-medium mb-1 text-muted">{{ __('Total Customer Datang') }}</p>
                                <h4 class="mb-0">{{ $total_customer_datang->count() ?? 0 }}</h4>
                            </div>
                            <div class="avatar avatar-md br-4 bg-danger-transparent ms-auto">
                                <i class="bx bx-category fs-20"></i>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <span class="badge bg-danger-transparent rounded-pill">{{ __('Tahun') }}
                                {{ activePeriod() }}
                            </span>
                            {{-- <a href="javascript:void(0);"
                                    class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ __('Lihat Detail') }}
                                </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12">
            <div class="col card-background">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <p class="fw-medium mb-1 text-muted">{{ __('Total Customer Tanya') }}</p>
                                <h4 class="mb-0">{{ $total_customer_tanya->count() ?? 0 }}</h4>
                            </div>
                            <div class="avatar avatar-md br-4 bg-success-transparent ms-auto">
                                <i class="bx bx-chat fs-20"></i>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <span class="badge bg-success-transparent rounded-pill">{{ __('Tahun') }}
                                {{ activePeriod() }}
                            </span>
                            {{-- <a href="javascript:void(0);"
                                    class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ __('Lihat Detail') }}
                                </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12">
            <div class="col card-background">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <p class="fw-medium mb-1 text-muted">{{ __('Total Customer Coba') }}</p>
                                <h4 class="mb-0">{{ $total_customer_coba->count() ?? 0 }}</h4>
                            </div>
                            <div class="avatar avatar-md br-4 bg-info-transparent ms-auto">
                                <i class="bx bx-closet fs-20"></i>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <span class="badge bg-info-transparent rounded-pill">{{ __('Tahun') }}
                                {{ activePeriod() }}
                            </span>
                            {{-- <a href="javascript:void(0);"
                                    class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ __('Lihat Detail') }}
                                </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12">
            <div class="col card-background">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <p class="fw-medium mb-1 text-muted">{{ __('Total Customer Beli') }}</p>
                                <h4 class="mb-0">{{ $total_customer_beli->count() ?? 0 }}</h4>
                            </div>
                            <div class="avatar avatar-md br-4 bg-secondary-transparent ms-auto">
                                <i class="bx bxs-cart fs-20"></i>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <span class="badge bg-secondary-transparent rounded-pill">{{ __('Tahun') }}
                                {{ activePeriod() }}
                            </span>
                            {{-- <a href="javascript:void(0);"
                                    class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ __('Lihat Detail') }}
                                </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('dashboard gsa')
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12">
                <div class="card custom-card">
                    {{-- <div class="card-body p-0">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            <form action="{{ route('dashboard.index') }}" method="GET" id="form-search">
                                @csrf

                                <div class="dropdown d-flex mt-3">
                                    <div class="me-2" style="width: 150px;">
                                        <select class = "form-select" name='status-toko' style="height: 100%;">
                                            <option value="aktif-all"
                                                {{ request()->get('status-toko') == 'aktif-all' ? 'selected' : '' }}
                                                id="filter-aktif-all">{{ __('Toko Aktif') }}</option>
                                            <option value="tidak-aktif-all"
                                                {{ request()->get('status-toko') == 'tidak-aktif-all' ? 'selected' : '' }}
                                                id="filter-tidak-aktif-all">{{ __('Toko Tidak Aktif') }}</option>
                                        </select>
                                    </div>

                                    <button type="submit"
                                        class="btn btn-sm btn-primary-light btn-wave waves-effect waves-light d-flex align-items-center me-2"
                                        name="submit" value="search">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            &nbsp;
                        </div>
                        <form action="{{ route('dashboard.index') }}" method="GET" id="form-search">
                            @csrf

                            <div class="dropdown d-flex mt-3">
                                <div class="me-2" style="width: 150px;">
                                    <select class = "form-select" name='status_toko' style="height: 100%;">
                                        <option value="all" {{ request()->get('status_toko') == 'all' ? 'selected' : '' }}
                                            id="filter-all">{{ __('Semua Toko') }}</option>
                                        <option value="aktif" {{ request()->get('status_toko') == 'aktif' ? 'selected' : '' }}
                                            id="filter-aktif-all">{{ __('Toko Aktif') }}</option>
                                        <option value="tidak-aktif"
                                            {{ request()->get('status_toko') == 'tidak-aktif' ? 'selected' : '' }}
                                            id="filter-tidak-aktif-all">{{ __('Toko Tidak Aktif') }}</option>
                                    </select>
                                </div>

                                <button type="submit"
                                    class="btn btn-sm btn-primary-light btn-wave waves-effect waves-light d-flex align-items-center me-2"
                                    name="submit" value="search">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="card-title">
                        &nbsp;
                    </div>
                </div>
                <div class="card-body">
                    <div id="graph0"></div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="card-title">
                        &nbsp;
                    </div>
                    <div id="graph1"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        {{ __('Data Kunjungan Per Store') }}
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-xxl-5 col-xl-5 col-lg-12">
                            <div class="table-responsive">
                                <table class="table text-nowrap table-striped table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <td scope="col" class="fw-semibold">{{ __('Store') }}</td>
                                            <td scope="col" align="right" class="fw-semibold">{{ __('Datang') }}
                                            <td scope="col" align="right" class="fw-semibold">{{ __('Tanya') }}
                                            <td scope="col" align="right" class="fw-semibold">{{ __('Coba') }}
                                            <td scope="col" align="right" class="fw-semibold">{{ __('Beli') }}
                                        </tr>
                                    </thead>
                                    <tbody class="top-selling">
                                        @if (count($data_kunjungan) > 0)
                                            @foreach ($data_kunjungan as $row)
                                                <tr>
                                                    <td>
                                                        <span>{{ $row->nama_store }}</span>
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

                        <div class="col-xxl-7 col-xl-7 col-lg-12">
                            <div id="graph2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-xxl-5 col-xl-5 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        {{ __('Data Kunjungan Per Store') }}
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <td scope="col" class="fw-semibold">{{ __('Store') }}</td>
                                    <td scope="col" align="right" class="fw-semibold">{{ __('Datang') }}
                                    <td scope="col" align="right" class="fw-semibold">{{ __('Tanya') }}
                                    <td scope="col" align="right" class="fw-semibold">{{ __('Coba') }}
                                    <td scope="col" align="right" class="fw-semibold">{{ __('Beli') }}
                                </tr>
                            </thead>
                            <tbody class="top-selling">
                                @if (count($data_kunjungan) > 0)
                                    @foreach ($data_kunjungan as $row)
                                        <tr>
                                            <td>
                                                <span>{{ $row->nama_store }}</span>
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
        <div class="col-xxl-7 col-xl-7 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="card-title">
                        &nbsp;
                    </div>
                    <div id="graph2"></div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
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
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
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
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
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
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
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
            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12 col-lg-12">
                        <div class="card border border-primary custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    {{ __('Total Penjualan') }} <span class="text-danger">{{ __('HARI') }}</span>
                                    {{ __('ini (Per Store)') }}
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-striped table-hover">
                                        <thead class="table-primary">
                                            <tr>
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
                                            @if (count($penjualan_hari_ini_per_store) > 0)
                                                @foreach ($penjualan_hari_ini_per_store as $row)
                                                    @php
                                                        $sum_qty = $sum_qty + $row->qty;
                                                        $sum_nominal = $sum_nominal + $row->nominal;
                                                    @endphp
                                                    <tr>
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
                                                    <td colspan="4" align="center">
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <td colspan="2">
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
                    <div class="col-xxl-12 col-xl-12 col-lg-12">
                        <div class="card border border-primary custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    {{ __('Total Penjualan') }} <span class="text-danger">{{ __('BULAN') }}</span>
                                    {{ __('ini (Per Store)') }}
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-striped table-hover">
                                        <thead class="table-primary">
                                            <tr>
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
                                            @if (count($penjualan_bulan_ini_per_store) > 0)
                                                @foreach ($penjualan_bulan_ini_per_store as $row)
                                                    @php
                                                        $sum_qty = $sum_qty + $row->qty;
                                                        $sum_nominal = $sum_nominal + $row->nominal;
                                                    @endphp
                                                    <tr>
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
                                                    <td colspan="4" align="center">
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <td colspan="2">
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
                    <div class="col-xxl-12 col-xl-12 col-lg-12">
                        <div class="card border border-primary custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    {{ __('Total Penjualan') }} <span class="text-danger">{{ __('TAHUN') }}</span>
                                    {{ __('ini (Per Store)') }}
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-striped table-hover">
                                        <thead class="table-primary">
                                            <tr>
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
                                            @if (count($penjualan_tahun_ini_per_store) > 0)
                                                @foreach ($penjualan_tahun_ini_per_store as $row)
                                                    @php
                                                        $sum_qty = $sum_qty + $row->qty;
                                                        $sum_nominal = $sum_nominal + $row->nominal;
                                                    @endphp
                                                    <tr>
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
                                                    <td colspan="4" align="center">
                                                        <span
                                                            class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <td colspan="2">
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
            </div>
        </div> --}}
    {{-- @else --}}
    {{-- <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Total Penjualan') }} <span class="text-danger">{{ __('HARI') }}</span>
                            {{ __('ini (Per Tipe Barang)') }}
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
                                        <td scope="col" class="fw-semibold">{{ __('Brand') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Tipe Barang') }}</td>
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
                                    @if (count($penjualan_hari_ini_per_tipe_barang) > 0)
                                        @foreach ($penjualan_hari_ini_per_tipe_barang as $row)
                                            @php
                                                $sum_qty = $sum_qty + $row->qty;
                                                $sum_nominal = $sum_nominal + $row->nominal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span>{{ $row->parameter_1 }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->parameter_2 }}</span>
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
                                            <td colspan="4" align="center">
                                                <span class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="table-primary">
                                    <tr>
                                        <td colspan="2">
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
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Total Penjualan') }} <span class="text-danger">{{ __('BULAN') }}</span>
                            {{ __('ini (Per Tipe Barang)') }}
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
                                        <td scope="col" class="fw-semibold">{{ __('Brand') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Tipe Barang') }}</td>
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
                                    @if (count($penjualan_bulan_ini_per_tipe_barang) > 0)
                                        @foreach ($penjualan_bulan_ini_per_tipe_barang as $row)
                                            @php
                                                $sum_qty = $sum_qty + $row->qty;
                                                $sum_nominal = $sum_nominal + $row->nominal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span>{{ $row->parameter_1 }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->parameter_2 }}</span>
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
                                            <td colspan="4" align="center">
                                                <span class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="table-primary">
                                    <tr>
                                        <td colspan="2">
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
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Total Penjualan') }} <span class="text-danger">{{ __('TAHUN') }}</span>
                            {{ __('ini (Per Tipe Barang)') }}
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
                                        <td scope="col" class="fw-semibold">{{ __('Brand') }}</td>
                                        <td scope="col" class="fw-semibold">{{ __('Tipe Barang') }}</td>
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
                                    @if (count($penjualan_tahun_ini_per_tipe_barang) > 0)
                                        @foreach ($penjualan_tahun_ini_per_tipe_barang as $row)
                                            @php
                                                $sum_qty = $sum_qty + $row->qty;
                                                $sum_nominal = $sum_nominal + $row->nominal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span>{{ $row->parameter_1 }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $row->parameter_2 }}</span>
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
                                            <td colspan="4" align="center">
                                                <span class="fw-semibold text-danger">{{ __('Tidak ada data') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="table-primary">
                                    <tr>
                                        <td colspan="2">
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
        </div> --}}
    {{-- @endcan --}}
@endsection

<x-web-sweet-alert />

@push('scripts_vendor')
    <script src="{{ asset(config('common.path_template') . 'assets/libs/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset(config('common.path_template') . 'assets/libs/highcharts/exporting.js') }}"></script>
    <script src="{{ asset(config('common.path_template') . 'assets/libs/highcharts/offline-exporting.js') }}"></script>
@endpush

@include('layouts.includes.select2')

@push('scripts')
    <script>
        var data_store_graph = {{ Js::from($data_store_graph) }};
        var total_datang_graph = {{ Js::from($total_datang_graph) }};
        var total_tanya_graph = {{ Js::from($total_tanya_graph) }};
        var total_coba_graph = {{ Js::from($total_coba_graph) }};
        var total_beli_graph = {{ Js::from($total_beli_graph) }};

        var total_nominal_goldmart_graph = {{ Js::from($total_nominal_goldmart_graph) }};
        var total_nominal_goldmaster_graph = {{ Js::from($total_nominal_goldmaster_graph) }};

        Highcharts.chart('graph0', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Data Kunjungan'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: data_store_graph,
                crosshair: true,
                accessibility: {
                    description: 'Store'
                }
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
                data: total_datang_graph
            }, {
                name: 'Tanya',
                data: total_tanya_graph
            }, {
                name: 'Coba',
                data: total_coba_graph
            }, {
                name: 'Beli',
                data: total_beli_graph
            }]
        });

        Highcharts.chart('graph2', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Data Kunjungan Per Store'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: data_store_graph,
                crosshair: true,
                accessibility: {
                    description: 'Store'
                }
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
                data: total_datang_graph
            }, {
                name: 'Tanya',
                data: total_tanya_graph
            }, {
                name: 'Coba',
                data: total_coba_graph
            }, {
                name: 'Beli',
                data: total_beli_graph
            }]
        });

        Highcharts.chart('graph1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Data Penjualan'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ],
                crosshair: true,
                accessibility: {
                    description: 'Bulan'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rp.'
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
                name: 'Goldmart',
                data: total_nominal_goldmart_graph
            }, {
                name: 'Goldmaster',
                data: total_nominal_goldmaster_graph
            }]
        });
    </script>
@endpush
