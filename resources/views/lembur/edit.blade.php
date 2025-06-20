@extends('layouts.main')

@section('container')
<div class="page-inner">
    <h4 class="fw-bold mb-3">Edit Data Lembur</h4>

    <form action="{{ route('lembur.update', $lembur->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="karyawan_id" class="form-label">Nama Karyawan</label>
            <select name="karyawan_id" id="karyawan_id" class="form-select" required>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id }}" {{ $lembur->karyawan_id == $karyawan->id ? 'selected' : '' }}>
                        {{ $karyawan->nama }} ({{ $karyawan->nip }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Lembur</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $lembur->tanggal }}" required>
        </div>

        <div class="mb-3">
            <label for="jam" class="form-label">Jumlah Jam</label>
            <input type="number" name="jam" id="jam" class="form-control" value="{{ $lembur->jam }}" required>
        </div>

        <div class="mb-3">
            <label for="upah" class="form-label">Total Upah</label>
            <input type="number" name="upah" id="upah" class="form-control" value="{{ $lembur->upah }}" required>
        </div>

        <a href="{{ route('lembur.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<!-- Modal Tambah Lembur -->
<div class="modal fade" id="modalTambahLembur" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('lembur.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalLabel">Tambah Lembur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Karyawan</label>
            <select name="karyawan_id" class="form-select" required>
              <option value="">-- Pilih --</option>
              @foreach($karyawans as $kar)
                <option value="{{ $kar->id }}">{{ $kar->nama }} ({{ $kar->nip }})</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label>Jumlah Jam</label>
                <input type="number" name="jam" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label>Upah (Rp)</label>
                <input type="number" name="upah" class="form-control" required>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
