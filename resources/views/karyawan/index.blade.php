@extends('layouts.main')

@php
    $groups = [
        'Pengurus',
        'Information Technology and General Affair',
        'Compliance and Internal Audit',
        'Sales and Marketing',
        'Risk Management',
        'Settlement and Custodian',
        'Finance and Accounting',
    ];
@endphp

@section('container')
<div class="page-inner">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Data Karyawan</h4>
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('karyawan.index') }}" class="me-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIP..." value="{{ request('search') }}">
                    </form>
                    @if(auth()->user()->role === 'manager')
                        <a href="{{ route('karyawan.export') }}" class="btn btn-success btn-sm me-2">
                            <i class="fa fa-download"></i> Export Excel
                        </a>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addKaryawanModal">
                            <i class="fa fa-plus"></i> Tambah Karyawan
                        </button>
                    @endif
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2">NIP</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">Jabatan</th>
                                <th rowspan="2">Group</th>
                                <th rowspan="2">Gaji Pokok</th>
                                <th rowspan="2">Tunjangan</th>
                                <th colspan="2" class="text-center">Karyawan</th>
                                <th colspan="2" class="text-center">Perusahaan</th>
                                @if(auth()->user()->role === 'manager')
                                    <th rowspan="2">Aksi</th>
                                @endif
                            </tr>
                            <tr>
                                <th>BPJS TK</th>
                                <th>BPJS KES</th>
                                <th>BPJS TK</th>
                                <th>BPJS KES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawans as $karyawan)
                            <tr>
                                <td>{{ $karyawan->nip }}</td>
                                <td>{{ $karyawan->nama }}</td>
                                <td>{{ $karyawan->jabatan }}</td>
                                <td>{{ $karyawan->group }}</td>
                                <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($karyawan->tunjangan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($karyawan->bpjs_tk, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($karyawan->bpjs_kes, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($karyawan->bpjs_tk_perusahaan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($karyawan->bpjs_kes_perusahaan, 0, ',', '.') }}</td>
                                @if(auth()->user()->role === 'manager')
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
                                @endif
                            </tr>

                            <!-- Modal Edit Karyawan -->
                            <div class="modal fade" id="editKaryawanModal{{ $karyawan->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title">Edit Karyawan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group mb-2">
                                                    <label>NIP</label>
                                                    <input type="text" name="nip" class="form-control" value="{{ $karyawan->nip }}" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama" class="form-control" value="{{ $karyawan->nama }}" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Jabatan</label>
                                                    <select name="jabatan" class="form-control">
                                                        <option value="Direktur Utama" {{ $karyawan->jabatan == 'Direktur Utama' ? 'selected' : '' }}>Direktur Utama</option>
                                                        <option value="Direktur" {{ $karyawan->jabatan == 'Direktur' ? 'selected' : '' }}>Direktur</option>
                                                        <option value="Group Head" {{ $karyawan->jabatan == 'Group Head' ? 'selected' : '' }}>Group Head</option>
                                                        <option value="Staf" {{ $karyawan->jabatan == 'Staf' ? 'selected' : '' }}>Staf</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Group</label>
                                                    <select name="group" class="form-control">
                                                        @foreach ($groups as $group)
                                                            <option value="{{ $group }}" {{ $karyawan->group == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Gaji Pokok (Rp)</label>
                                                    <input type="text" name="gaji_pokok" class="form-control currency-input" value="{{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Tunjangan (Rp)</label>
                                                    <input type="text" name="tunjangan" class="form-control currency-input" value="{{ number_format($karyawan->tunjangan, 0, ',', '.') }}">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>BPJS TK (Karyawan)</label>
                                                    <input type="text" name="bpjs_tk" class="form-control currency-input" value="{{ number_format($karyawan->bpjs_tk, 0, ',', '.') }}">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>BPJS Kes (Karyawan)</label>
                                                    <input type="text" name="bpjs_kes" class="form-control currency-input" value="{{ number_format($karyawan->bpjs_kes, 0, ',', '.') }}">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>BPJS TK (Perusahaan)</label>
                                                    <input type="text" name="bpjs_tk_perusahaan" class="form-control currency-input" value="{{ number_format($karyawan->bpjs_tk_perusahaan, 0, ',', '.') }}">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>BPJS Kes (Perusahaan)</label>
                                                    <input type="text" name="bpjs_kes_perusahaan" class="form-control currency-input" value="{{ number_format($karyawan->bpjs_kes_perusahaan, 0, ',', '.') }}">
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
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">Belum ada data karyawan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Tambah Karyawan -->
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
                                    <select name="jabatan" class="form-control">
                                        <option value="Direktur Utama">Direktur Utama</option>
                                        <option value="Direktur">Direktur</option>
                                        <option value="Group Head">Group Head</option>
                                        <option value="Staf">Staf</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Group</label>
                                    <select name="group" class="form-control">
                                        @foreach ($groups as $group)
                                            <option value="{{ $group }}">{{ $group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Gaji Pokok (Rp)</label>
                                    <input type="text" name="gaji_pokok" class="form-control currency-input">
                                </div>
                                <div class="form-group">
                                    <label>Tunjangan (Rp)</label>
                                    <input type="text" name="tunjangan" class="form-control currency-input">
                                </div>
                                <div class="form-group">
                                    <label>BPJS TK (Karyawan)</label>
                                    <input type="text" name="bpjs_tk" class="form-control currency-input">
                                </div>
                                <div class="form-group">
                                    <label>BPJS Kes (Karyawan)</label>
                                    <input type="text" name="bpjs_kes" class="form-control currency-input">
                                </div>
                                <div class="form-group">
                                    <label>BPJS TK (Perusahaan)</label>
                                    <input type="text" name="bpjs_tk_perusahaan" class="form-control currency-input">
                                </div>
                                <div class="form-group">
                                    <label>BPJS Kes (Perusahaan)</label>
                                    <input type="text" name="bpjs_kes_perusahaan" class="form-control currency-input">
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

        document.querySelectorAll('.currency-input').forEach(input => {
            input.addEventListener('input', function () {
                let value = this.value.replace(/[^\d]/g, '');
                this.value = new Intl.NumberFormat('id-ID').format(value);
            });
        });
    });
</script>
@endpush
