@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="col-md-12">
        <div class="card">

            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Data Karyawan</h4>
                <div>
                    <form method="GET" action="{{ route('karyawan.index') }}" class="d-inline-block me-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIP..." value="{{ request('search') }}">
                    </form>
                    <a href="{{ route('karyawan.export') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-download"></i> Export Excel
                    </a>
                    <button class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addKaryawanModal">
                        <i class="fa fa-plus"></i> Tambah Karyawan
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Gaji Pokok</th>
                                <th>Tunjangan</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawans as $karyawan)
                            <tr>
                                <td>{{ $karyawan->nip }}</td>
                                <td>{{ $karyawan->nama }}</td>
                                <td>{{ $karyawan->jabatan }}</td>
                                <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($karyawan->tunjangan, 0, ',', '.') }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <button type="button" class="btn btn-link btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#editKaryawanModal{{ $karyawan->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="{{ route('karyawan.destroy', $karyawan->id) }}" class="btn btn-link btn-danger btn-lg delete-confirm">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="editKaryawanModal{{ $karyawan->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title">Edit Karyawan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>NIP</label>
                                                    <input type="text" name="nip" value="{{ $karyawan->nip }}" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama" value="{{ $karyawan->nama }}" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jabatan</label>
                                                    <input type="text" name="jabatan" value="{{ $karyawan->jabatan }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Gaji Pokok (Rp)</label>
                                                    <input type="text" name="gaji_pokok" class="form-control currency-input" value="{{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tunjangan (Rp)</label>
                                                    <input type="text" name="tunjangan" class="form-control currency-input" value="{{ number_format($karyawan->tunjangan, 0, ',', '.') }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data karyawan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal Tambah --}}
            <div class="modal fade" id="addKaryawanModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('karyawan.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Tambah Karyawan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" name="nip" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Gaji Pokok (Rp)</label>
                                    <input type="text" name="gaji_pokok" class="form-control currency-input">
                                </div>
                                <div class="form-group">
                                    <label>Tunjangan (Rp)</label>
                                    <input type="text" name="tunjangan" class="form-control currency-input">
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Konfirmasi hapus
        document.querySelectorAll('.delete-confirm').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data karyawan yang dihapus tidak bisa dikembalikan!',
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

        // Format input currency
        document.querySelectorAll('.currency-input').forEach(input => {
            input.addEventListener('input', function () {
                let value = this.value.replace(/[^\d]/g, '');
                this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
            });
        });
    });
</script>
@endpush
