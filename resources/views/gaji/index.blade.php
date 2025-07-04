@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    Data Gaji Bulan {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}
                </h4>
                @if(auth()->user()->role === 'manager')
                <div class="d-flex gap-2">
                    <a href="{{ route('gaji.exportPdf', ['bulan' => $bulan, 'search' => request('search')]) }}" class="btn btn-danger btn-sm">
                        <i class="fa fa-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('gaji.exportExcel', ['bulan' => $bulan, 'search' => request('search')]) }}" class="btn btn-success btn-sm">
                        <i class="fa fa-file-excel"></i> Excel
                    </a>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addGajiModal">
                        <i class="fa fa-plus"></i> Tambah Gaji
                    </button>
                </div>
                @endif
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Filter -->
                <div class="mb-4">
                    <form method="GET" action="{{ route('gaji.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="bulan" class="form-label fw-bold">📅 Pilih Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    @foreach($daftarBulan as $bln)
                                        <option value="{{ $bln }}" {{ $bln === $bulan ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($bln)->translatedFormat('F Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="search" class="form-label fw-bold">👤 Cari Nama / NIP</label>
                                <select name="search" id="search" class="form-select">
                                    <option value="">-- Semua Karyawan --</option>
                                    @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->nip }}" {{ request('search') == $karyawan->nip ? 'selected' : '' }}>
                                            {{ $karyawan->nama }} ({{ $karyawan->nip }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa fa-filter me-1"></i> Tampilkan Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">NIP</th>
                                <th rowspan="2">Gaji Pokok</th>
                                <th rowspan="2">Perjalanan Dinas</th>
                                <th rowspan="2">Lembur</th>
                                <th rowspan="2">THR</th>
                                <th rowspan="2">Pakaian Dinas</th>
                                <th colspan="2" class="text-center">Karyawan</th>
                                <th colspan="2" class="text-center">Perusahaan</th>
                                <th rowspan="2">PPH</th>
                                <th rowspan="2">Total</th>
                                <th rowspan="2">Tunjangan</th>
                                <th rowspan="2">No Rekening</th>
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
                            @forelse($gajis as $gaji)
                            <tr>
                                <td>{{ $gaji->karyawan->nama }}</td>
                                <td>{{ $gaji->karyawan->nip }}</td>
                                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->perjalanan_dinas, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->lembur, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->thr, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->pakaian_dinas, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->bpjs_tk, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->bpjs_kes, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->bpjs_tk_perusahaan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->bpjs_kes_perusahaan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->pph, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->total, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->karyawan->tunjangan, 0, ',', '.') }}</td>
                                <td>{{ $gaji->karyawan->no_rekening ?? '-' }}</td>
                                @if(auth()->user()->role === 'manager')
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editGajiModal{{ $gaji->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <form action="{{ route('gaji.destroy', $gaji->id) }}" method="POST" class="d-inline delete-confirm-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr><td colspan="16" class="text-center">Tidak ada data gaji.</td></tr>
                            @endforelse
                        </tbody>

                        <!-- Tambahan Footer -->
                        <tfoot>
                            <tr class="table-warning fw-bold">
                                <td colspan="12" class="text-end">Jumlah Karyawan:</td>
                                <td colspan="2">{{ $gajis->count() }} Orang</td>
                            </tr>
                            <tr class="table-success fw-bold">
                                <td colspan="12" class="text-end">Total Seluruh Gaji:</td>
                                <td colspan="2">Rp {{ number_format($gajis->sum('total'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @include('gaji.create-inline', ['karyawans' => $karyawans, 'bulan' => $bulan, 'daftarBulan' => $daftarBulan])
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.currency-input').forEach(input => {
        input.addEventListener('input', function () {
            let value = this.value.replace(/[^\d]/g, '');
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });

    document.querySelectorAll('.delete-confirm-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endpush
