@extends('layouts.master')

@section('page_title')
    {{ __('Dashboard') }}
@endsection

@section('section_header_title')
    {{ __('Dashboard') }}
@endsection

@section('page_content')
    <x-web-alert-message />

    <div class="container">
        <div class="element-heading">
            <h6>Line One</h6>
        </div>
    </div>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body pb-0">
                <div class="chart-wrapper">
                    <div id="lineChart1"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Element Heading -->
    <div class="container">
        <div class="element-heading mt-3">
            <h6>Line Two</h6>
        </div>
    </div>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body pb-0">
                <div class="chart-wrapper">
                    <div id="lineChart2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_vendor')
    <script src="{{ asset(config('common.path_template') . 'js/apexcharts.min.js') }}"></script>
    <script src="{{ asset(config('common.path_template') . 'js/chart-active.js') }}"></script>
@endpush

@push('scripts')
    <script></script>
@endpush
