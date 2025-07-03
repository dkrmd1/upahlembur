<!-- Modal Tambah Gaji -->
<div class="modal fade" id="addGajiModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('gaji.store') }}" method="POST" id="formAddGaji">
            @csrf
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Tambah Data Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="bulan" value="{{ $bulan }}">

                    <div class="form-group mb-2">
                        <label>Nama Karyawan</label>
                        <select name="karyawan_id" class="form-control" required id="karyawanSelect">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}"
                                    data-nip="{{ $karyawan->nip }}"
                                    data-gaji_pokok="{{ $karyawan->gaji_pokok }}"
                                    data-tunjangan="{{ $karyawan->tunjangan }}"
                                    data-rekening="{{ $karyawan->no_rekening ?? '-' }}"
                                    data-bpjs_kes="{{ $karyawan->bpjs_kes }}"
                                    data-bpjs_tk="{{ $karyawan->bpjs_tk }}"
                                    data-bpjs_tk_perusahaan="{{ $karyawan->bpjs_tk_perusahaan }}"
                                    data-bpjs_kes_perusahaan="{{ $karyawan->bpjs_kes_perusahaan }}"
                                >
                                    {{ $karyawan->nama }} ({{ $karyawan->nip }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2"><label>Gaji Pokok</label><input type="text" name="gaji_pokok" class="form-control currency-input" id="gajiPokok" readonly></div>
                    <div class="form-group mb-2"><label>Tunjangan</label><input type="text" name="tunjangan" class="form-control currency-input" id="tunjanganInput" readonly></div>
                    <div class="form-group mb-2"><label>No. Rekening</label><input type="text" name="rekening" class="form-control" id="rekeningInput" readonly></div>
                    <div class="form-group mb-2"><label>Perjalanan Dinas</label><input type="text" name="perjalanan_dinas" class="form-control currency-input" required></div>
                    <div class="form-group mb-2"><label>Lembur</label><input type="text" name="lembur" class="form-control currency-input" id="lemburInput" readonly></div>
                    <div class="form-group mb-2"><label>THR</label><input type="text" name="thr" class="form-control currency-input" required></div>
                    <div class="form-group mb-2"><label>Pakaian Dinas</label><input type="text" name="pakaian_dinas" class="form-control currency-input" required></div>
                    <div class="form-group mb-2"><label>BPJS Kes</label><input type="text" name="bpjs_kes" class="form-control currency-input" id="bpjsKes" readonly></div>
                    <div class="form-group mb-2"><label>BPJS TK</label><input type="text" name="bpjs_tk" class="form-control currency-input" id="bpjsTk" readonly></div>
                    <div class="form-group mb-2"><label>BPJS TK (Perusahaan)</label><input type="text" name="bpjs_tk_perusahaan" class="form-control currency-input" id="bpjsTkPerusahaan" readonly></div>
                    <div class="form-group mb-2"><label>BPJS Kes (Perusahaan)</label><input type="text" name="bpjs_kes_perusahaan" class="form-control currency-input" id="bpjsKesPerusahaan" readonly></div>
                    <div class="form-group mb-2"><label>PPH</label><input type="text" name="pph" class="form-control currency-input" required></div>
                </div>

                <div class="modal-footer border-0">
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
    // Format input currency (bisa ketik hanya angka, tampil terformat)
    document.querySelectorAll('.currency-input').forEach(input => {
        input.addEventListener('input', function () {
            if (this.hasAttribute('readonly')) return;
            let value = this.value.replace(/[^\d]/g, '');
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });

    const select = document.getElementById('karyawanSelect');
    const gajiPokokInput = document.getElementById('gajiPokok');
    const tunjanganInput = document.getElementById('tunjanganInput');
    const rekeningInput = document.getElementById('rekeningInput');
    const bpjsKesInput = document.getElementById('bpjsKes');
    const bpjsTkInput = document.getElementById('bpjsTk');
    const bpjsTkPerusahaanInput = document.getElementById('bpjsTkPerusahaan');
    const bpjsKesPerusahaanInput = document.getElementById('bpjsKesPerusahaan');
    const lemburInput = document.getElementById('lemburInput');

    select.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];

        if (!this.value) {
            // kosongkan semua field jika batal pilih
            gajiPokokInput.value = '';
            tunjanganInput.value = '';
            rekeningInput.value = '';
            bpjsKesInput.value = '';
            bpjsTkInput.value = '';
            bpjsTkPerusahaanInput.value = '';
            bpjsKesPerusahaanInput.value = '';
            lemburInput.value = '';
            return;
        }

        gajiPokokInput.value = new Intl.NumberFormat('id-ID').format(selected.getAttribute('data-gaji_pokok') || 0);
        tunjanganInput.value = new Intl.NumberFormat('id-ID').format(selected.getAttribute('data-tunjangan') || 0);
        rekeningInput.value = selected.getAttribute('data-rekening') || '-';
        bpjsKesInput.value = new Intl.NumberFormat('id-ID').format(selected.getAttribute('data-bpjs_kes') || 0);
        bpjsTkInput.value = new Intl.NumberFormat('id-ID').format(selected.getAttribute('data-bpjs_tk') || 0);
        bpjsTkPerusahaanInput.value = new Intl.NumberFormat('id-ID').format(selected.getAttribute('data-bpjs_tk_perusahaan') || 0);
        bpjsKesPerusahaanInput.value = new Intl.NumberFormat('id-ID').format(selected.getAttribute('data-bpjs_kes_perusahaan') || 0);

        // Ambil total lembur via fetch API
        fetch(`/gaji/total-lembur?karyawan_id=${this.value}&bulan={{ $bulan }}`)
            .then(res => res.json())
            .then(data => {
                lemburInput.value = new Intl.NumberFormat('id-ID').format(data.total_lembur || 0);
            })
            .catch(() => {
                lemburInput.value = '0';
            });
    });
});
</script>
@endpush
