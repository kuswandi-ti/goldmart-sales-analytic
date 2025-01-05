@push('styles_vendor')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset(config('common.path_template') . 'assets/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset(config('common.path_template') . 'assets/libs/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset(config('common.path_template') . 'assets/libs/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset(config('common.path_template') . 'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush

@push('scripts_vendor')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset(config('common.path_template') . 'assets/libs/datatables/datatables.min.js') }}"></script>
    <script
        src="{{ asset(config('common.path_template') . 'assets/libs/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script
        src="{{ asset(config('common.path_template') . 'assets/libs/datatables/Select-1.2.4/js/dataTables.select.min.js') }}">
    </script>
    <script src="{{ asset(config('common.path_template') . 'assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
@endpush
