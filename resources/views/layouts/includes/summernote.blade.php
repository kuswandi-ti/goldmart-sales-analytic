@push('styles_vendor')
    <link rel="stylesheet"
        href="{{ asset(config('common.path_template_admin') . 'assets/modules/summernote/summernote-bs4.css') }}">
@endpush

@push('scripts_vendor')
    <script src="{{ asset(config('common.path_template_admin') . 'assets/modules/summernote/summernote-bs4.js') }}">
    </script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                airMode: true,
            });
        });
    </script>
@endpush
