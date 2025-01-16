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
            <div class="col-xxl-4 col-sm-12">
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="fw-medium mb-1 text-muted">{{ __('Total Semua Penjualan (Value)') }}</p>
                                    <h3 class="mb-0">{{ __('Rp.') }}
                                        {{ formatAmount($total_sales_value->total_sales_value) }}</h3>
                                </div>
                                <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
                                    <i class="bx bxs-badge-dollar fs-20"></i>
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

            <div class="col-xxl-4 col-sm-12">
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="fw-medium mb-1 text-muted">{{ __('Total Semua Penjualan (Pcs)') }}</p>
                                    <h3 class="mb-0">{{ formatAmount($total_sales_pcs->total_sales_pcs) }}</h3>
                                </div>
                                <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
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

            <div class="col-xxl-4 col-sm-12">
                <div class="col card-background">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class="fw-medium mb-1 text-muted">{{ __('Total Customer Visit') }}</p>
                                    <h3 class="mb-0">{{ $total_customer_visit->total_customer_visit }}</h3>
                                </div>
                                <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
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
        </div>
    @endcan
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
@endsection

@push('scripts')
    <script></script>
@endpush
