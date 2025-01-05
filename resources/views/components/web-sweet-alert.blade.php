@push('scripts')
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 7000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    </script>

    @if ($message = Session::get('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ $message }}"
            })
        </script>
    @endif

    @if ($message = Session::get('warning'))
        <script>
            Toast.fire({
                icon: 'warning',
                title: "{{ $message }}"
            })
        </script>
    @endif

    @if ($message = Session::get('info'))
        <script>
            Toast.fire({
                icon: 'info',
                title: "{{ $message }}"
            })
        </script>
    @endif
@endpush
