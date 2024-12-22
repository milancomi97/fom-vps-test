{{-- resources/views/partials/alert.blade.php --}}
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            text: "",
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: {!! json_encode(session('error')) !!},
            text: "",
            showConfirmButton: true,
        });
    </script>
@endif

@if (session('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: '{{ session('info') }}',
            text: "",
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif
