@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="col-md-12">
        <div class="card">

            {{-- Header --}}
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Laporan Lembur</h4>
                <form method="GET" class="d-flex align-items-center">
                    <select name="bulan" class="form-select me-2">
                        @foreach(range(1, 12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="tahun" class="form-control me-2" value="{{ $tahun ?? date('Y') }}" />

                    <select name="karyawan_id" class="form-select me-2">
                        <option value="">Semua Karyawan</option>
                        @foreach ($karyawans as $kar)
                            <option value="{{ $kar->id }}" {{ request('karyawan_id') == $kar->id ? 'selected' : '' }}>
                                {{ $kar->nama }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm me-2">Tampilkan</button>

                    <a href="{{ route('laporan.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'karyawan_id' => request('karyawan_id')]) }}" class="btn btn-danger btn-sm me-2">
                        <i class="fa fa-file-pdf"></i> PDF
                    </a>

                    <a href="{{ route('laporan.export.excel', ['bulan' => $bulan, 'tahun' => $tahun, 'karyawan_id' => request('karyawan_id')]) }}" class="btn btn-success btn-sm">
                        <i class="fa fa-file-excel"></i> Excel
                    </a>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Upah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use Carbon\Carbon;
                            @endphp
                            @forelse ($lemburData as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->karyawan->nama ?? '-' }}</td>
                                    <td>{{ $item->karyawan->nip ?? '-' }}</td>
                                    <td>{{ Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l') }}</td>
                                    <td>{{ $item->jam }} Jam</td>
                                    <td>Rp {{ number_format($item->upah, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data lembur.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total</th>
                                <th>{{ $totalJam }} Jam</th>
                                <th>Rp {{ number_format($totalUpah, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
