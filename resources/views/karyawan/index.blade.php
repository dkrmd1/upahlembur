@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="col-md-12">
        <div class="card">
            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="card-title mb-0">Data Karyawan</h4>
                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('karyawan.index') }}" method="GET" class="d-flex align-items-center">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau NIP..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary">Cari</button>
                    </form>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah Karyawan
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Gaji Pokok</th>
                                <th>Tunjangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawans as $kar)
                                <tr>
                                    <td>{{ $kar->nip }}</td>
                                    <td>{{ $kar->nama }}</td>
                                    <td>{{ $kar->jabatan }}</td>
                                    <td>Rp {{ number_format($kar->gaji_pokok, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($kar->tunjangan, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $kar->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('karyawan.destroy', $kar->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div class="modal fade" id="modalEdit{{ $kar->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $kar->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('karyawan.update', $kar->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Karyawan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-2">
                                                        <label>NIP</label>
                                                        <input type="text" name="nip" class="form-control" value="{{ $kar->nip }}" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama" class="form-control" value="{{ $kar->nama }}" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Jabatan</label>
                                                        <input type="text" name="jabatan" class="form-control" value="{{ $kar->jabatan }}" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Gaji Pokok</label>
                                                        <input type="number" name="gaji_pokok" class="form-control" value="{{ $kar->gaji_pokok }}" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Tunjangan</label>
                                                        <input type="number" name="tunjangan" class="form-control" value="{{ $kar->tunjangan }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('karyawan.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
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
                        <input type="text" name="jabatan" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Gaji Pokok</label>
                        <input type="number" name="gaji_pokok" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Tunjangan</label>
                        <input type="number" name="tunjangan" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
