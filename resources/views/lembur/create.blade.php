@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Data Lembur</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('lembur.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Nama Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="form-select" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $kar)
                                <option value="{{ $kar->id }}">{{ $kar->nama }} ({{ $kar->nip }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Lembur</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="jam" class="form-label">Jumlah Jam</label>
                        <input type="number" name="jam" id="jam" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="upah" class="form-label">Total Upah (Rp)</label>
                        <input type="number" name="upah" id="upah" class="form-control" min="0" required>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('lembur.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
