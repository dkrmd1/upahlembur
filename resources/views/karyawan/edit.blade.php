<div class="modal fade" id="editKaryawanModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="form-group mb-2">
                        <label>NIP</label>
                        <input type="text" name="nip" id="editNip" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Jabatan</label>
                        <select name="jabatan" id="editJabatan" class="form-control">
                            <option value="Direktur Utama">Direktur Utama</option>
                            <option value="Direktur">Direktur</option>
                            <option value="Group Head">Group Head</option>
                            <option value="Staf">Staf</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Group</label>
                        <select name="group" id="editGroup" class="form-control">
                            @foreach ($groups as $group)
                                <option value="{{ $group }}">{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Gaji Pokok</label>
                        <input type="number" name="gaji_pokok" id="editGajiPokok" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>Tunjangan</label>
                        <input type="number" name="tunjangan" id="editTunjangan" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>BPJS TK (Karyawan)</label>
                        <input type="number" name="bpjs_tk" id="editBpjsTk" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>BPJS Kes (Karyawan)</label>
                        <input type="number" name="bpjs_kes" id="editBpjsKes" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>BPJS TK (Perusahaan)</label>
                        <input type="number" name="bpjs_tk_perusahaan" id="editBpjsTkPerusahaan" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>BPJS Kes (Perusahaan)</label>
                        <input type="number" name="bpjs_kes_perusahaan" id="editBpjsKesPerusahaan" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>Nomor Rekening</label>
                        <input type="text" name="no_rekening" id="editNoRekening" class="form-control">
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
