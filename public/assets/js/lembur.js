document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-confirm').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="${csrf}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
