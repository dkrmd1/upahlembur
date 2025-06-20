@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="col-md-12">
        <div class="card">

            {{-- Header --}}
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Laporan Lembur</h4>
                <form method="GET" class="d-flex">
                    <select name="bulan" class="form-select me-2">
                        @foreach(range(1, 12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="tahun" class="form-control me-2" value="{{ $tahun ?? date('Y') }}" />
                    <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>NIP</th>
                                <th>Jam Hari Kerja</th>
                                <th>Jam Hari Libur</th>
                                <th>Total Jam</th>
                                <th>Upah Hari Kerja</th>
                                <th>Upah Hari Libur</th>
                                <th>Total Upah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $i => $item)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $item->karyawan->nama ?? '-' }}</td>
                                    <td>{{ $item->karyawan->nip ?? '-' }}</td>
                                    <td class="text-center">{{ $item->hari_kerja_jam }} Jam</td>
                                    <td class="text-center">{{ $item->hari_libur_jam }} Jam</td>
                                    <td class="text-center">{{ $item->total_jam }} Jam</td>
                                    <td>Rp {{ number_format($item->hari_kerja_upah, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->hari_libur_upah, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->total_upah, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data lembur.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold text-end">
                                <th colspan="5">Total</th>
                                <th class="text-center">{{ $totalJam ?? 0 }} Jam</th>
                                <th colspan="3">Rp {{ number_format($totalUpah ?? 0, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
