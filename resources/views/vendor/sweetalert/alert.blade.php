@if (config('sweetalert.alwaysLoadJS') === true || Session::has('alert.config') || Session::has('alert.delete'))

    {{-- Load CSS animasi jika diaktifkan --}}
    @if (config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif

    {{-- Load tema jika bukan default --}}
    @if (config('sweetalert.theme') !== 'default')
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-{{ config('sweetalert.theme') }}" rel="stylesheet">
    @endif

    {{-- Load script jika tidak dilarang --}}
    @if (config('sweetalert.neverLoadJS') === false)
        <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @endif

    {{-- SweetAlert script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ✅ Suara notifikasi (opsional)
            const playSound = (url) => {
                const audio = new Audio(url);
                audio.play().catch(e => console.warn('Gagal memutar suara:', e));
            };

            // ✅ Konfirmasi hapus
            document.querySelectorAll('[data-confirm-delete]').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = el.getAttribute('href');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data yang dihapus tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;

                            const csrf = document.createElement('input');
                            csrf.type = 'hidden';
                            csrf.name = '_token';
                            csrf.value = '{{ csrf_token() }}';
                            form.appendChild(csrf);

                            const method = document.createElement('input');
                            method.type = 'hidden';
                            method.name = '_method';
                            method.value = 'DELETE';
                            form.appendChild(method);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // ✅ Notifikasi biasa (dari session)
            @if (Session::has('alert.config'))
                const config = {!! Session::pull('alert.config') !!};
                Swal.fire(config);

                // Play suara jika jenis alert = success
                if (config.icon === 'success') {
                    playSound('{{ asset("sounds/success.mp3") }}'); // Letakkan file ini di public/sounds
                } else if (config.icon === 'error') {
                    playSound('{{ asset("sounds/error.mp3") }}');
                }
            @endif
        });
    </script>
@endif
