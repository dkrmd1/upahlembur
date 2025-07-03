@extends('layouts.main')

@php
    $groups = [
        'Pengurus',
        'Information Technology and General Affair',
        'Compliance',
        'Internal Audit',
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
                                <th rowspan="2">No Rekening</th>
                                @if(auth()->user()->role === 'manager')
                                    <th rowspan="2" class="text-center">Aksi</th>
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
                                <td>{{ $karyawan->no_rekening }}</td>
                                @if(auth()->user()->role === 'manager')
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button type="button" class="btn btn-link btn-primary btn-sm edit-btn"
                                            data-id="{{ $karyawan->id }}"
                                            data-nip="{{ $karyawan->nip }}"
                                            data-nama="{{ $karyawan->nama }}"
                                            data-jabatan="{{ $karyawan->jabatan }}"
                                            data-group="{{ $karyawan->group }}"
                                            data-gaji_pokok="{{ $karyawan->gaji_pokok }}"
                                            data-tunjangan="{{ $karyawan->tunjangan }}"
                                            data-bpjs_tk="{{ $karyawan->bpjs_tk }}"
                                            data-bpjs_kes="{{ $karyawan->bpjs_kes }}"
                                            data-bpjs_tk_perusahaan="{{ $karyawan->bpjs_tk_perusahaan }}"
                                            data-bpjs_kes_perusahaan="{{ $karyawan->bpjs_kes_perusahaan }}"
                                            data-no_rekening="{{ $karyawan->no_rekening }}"
                                            data-bs-toggle="modal" data-bs-target="#editKaryawanModal">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="delete-form m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-danger btn-sm delete-confirm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">Belum ada data karyawan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @include('karyawan.create', ['groups' => $groups])
            @include('karyawan.edit', ['groups' => $groups])

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editForm');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                editForm.action = `/karyawan/${id}`;
                document.getElementById('editNip').value = this.dataset.nip;
                document.getElementById('editNama').value = this.dataset.nama;
                document.getElementById('editJabatan').value = this.dataset.jabatan;
                document.getElementById('editGroup').value = this.dataset.group;
                document.getElementById('editGajiPokok').value = this.dataset.gaji_pokok;
                document.getElementById('editTunjangan').value = this.dataset.tunjangan;
                document.getElementById('editBpjsTk').value = this.dataset.bpjs_tk;
                document.getElementById('editBpjsKes').value = this.dataset.bpjs_kes;
                document.getElementById('editBpjsTkPerusahaan').value = this.dataset.bpjs_tk_perusahaan;
                document.getElementById('editBpjsKesPerusahaan').value = this.dataset.bpjs_kes_perusahaan;
                document.getElementById('editNoRekening').value = this.dataset.no_rekening;
            });
        });
    });
</script>
@endpush
