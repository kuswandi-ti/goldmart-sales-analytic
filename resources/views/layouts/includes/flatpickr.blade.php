@push('styles_vendor')
    <link rel="stylesheet" href="{{ asset(config('common.path_template') . 'assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset(config('common.path_template') . 'assets/libs/@simonwep/pickr/themes/nano.min.css') }}">
@endpush

@push('scripts_vendor')
    <script src="{{ asset(config('common.path_template') . 'assets/libs/flatpickr/flatpickr.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        flatpickr(".flatpickr", {
            default_date_format: "{{ $setting_system['default_date_format'] }}",
            defaultDate: 'null',
            // static: true
        });
    </script>
@endpush
