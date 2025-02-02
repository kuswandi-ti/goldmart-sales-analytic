@extends('layouts.master')

@push('link_vendor')
    <script type="text/javascript" src="{{ config('midtrans.midtrans_snap_url') }}"
        data-client-key="{{ config('midtrans.midtrans_client_key') }}"></script>
@endpush

@push('styles_vendor')
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
@endpush

@section('page_title')
    {{ __('Customer Visit') }}
@endsection

@section('section_header_title')
    {{ __('Customer Visit') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    <x-breadcrumb-item url="{{ route('customervisit.index') }}" title="{{ __('Customer Visit') }}" />
    <x-breadcrumb-active title="{{ __('Checkout Customer Visit') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title me-1">{{ __('Order Summary') }}</div>
                </div>
                <div class="card-body p-0">
                    <div class="p-3 border-bottom border-block-end-dashed">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="text-muted op-7">{{ __('Sub Total') }}</div>
                            <div class="fw-semibold fs-14"> {{ formatAmount($total_nominal) }}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="text-muted op-7">{{ __('Discount') }}</div>
                            <div class="fw-semibold fs-14 text-success"> 0</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="text-muted op-7">{{ __('Delivery Charges') }}</div>
                            <div class="fw-semibold fs-14 text-danger"> 0</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-muted op-7">{{ __('Service Tax') }}</div>
                            <div class="fw-semibold fs-14"> 0</div>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-15">{{ __('Total') }}</div>
                            <div class="fw-semibold fs-16 text-dark"> {{ formatAmount($total_nominal) }}</div>
                        </div>
                    </div>
                </div>

                @can('transaksi bayar')
                    <div class="card-footer">
                        <button class="btn btn-danger btn-submit" id="pay-button">
                            {{ __('Bayar Sekarang') }}
                        </button>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection

@include('layouts.includes.select2')

@push('scripts')
    <script>
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran Berhasil");
                    //console.log(result);
                    document.location.href="{!! route('customervisit.index'); !!}";
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran pending");
                    //console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran gagal !");
                    //console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
@endpush
