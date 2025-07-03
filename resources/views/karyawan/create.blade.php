<div class="modal fade" id="addKaryawanModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('karyawan.store') }}" method="POST" id="formAddKaryawan">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Fields -->
                    <div class="form-group mb-2">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Jabatan</label>
                        <select name="jabatan" class="form-control">
                            <option value="Direktur Utama">Direktur Utama</option>
                            <option value="Direktur">Direktur</option>
                            <option value="Group Head">Group Head</option>
                            <option value="Staf">Staf</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Group</label>
                        <select name="group" class="form-control">
                            @foreach ($groups as $group)
                                <option value="{{ $group }}">{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Gaji Pokok</label>
                        <input type="text" name="gaji_pokok" class="form-control currency-input" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <label>Tunjangan</label>
                        <input type="text" name="tunjangan" class="form-control currency-input" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <label>BPJS TK (Karyawan)</label>
                        <input type="text" name="bpjs_tk" class="form-control currency-input" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <label>BPJS Kes (Karyawan)</label>
                        <input type="text" name="bpjs_kes" class="form-control currency-input" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <label>BPJS TK (Perusahaan)</label>
                        <input type="text" name="bpjs_tk_perusahaan" class="form-control currency-input" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <label>BPJS Kes (Perusahaan)</label>
                        <input type="text" name="bpjs_kes_perusahaan" class="form-control currency-input" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <label>Nomor Rekening</label>
                        <input type="text" name="no_rekening" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function formatRupiah(input) {
        // Hapus semua karakter bukan angka
        let angka = input.value.replace(/[^,\d]/g, '').toString();
        if (!angka) {
            input.value = '';
            return;
        }
        // Split ribuan dengan titik
        let split = angka.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        input.value = rupiah;
    }

    document.querySelectorAll('.currency-input').forEach(input => {
        input.addEventListener('input', function () {
            formatRupiah(this);
        });
    });
});
</script>
@endpush
