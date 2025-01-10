@push('styles_vendor')
    <link rel="stylesheet"
        href="{{ asset(config('common.path_template') . 'assets/libs/select2/dist/css/select2.min.css') }}">
@endpush

@push('styles')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endpush

@push('scripts_vendor')
    <script src="{{ asset(config('common.path_template') . 'assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(".select2").select2({
            // placeholder: "{{ __('Pilih salah satu ...') }}",
            allowClear: true,
            dir: "ltr"
        });
    </script>
@endpush
