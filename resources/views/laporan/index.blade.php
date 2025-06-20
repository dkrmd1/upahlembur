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
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>NIP</th>
                                <th>Total Jam</th>
                                <th>Total Upah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->karyawan->nama ?? '-' }}</td>
                                    <td>{{ $item->karyawan->nip ?? '-' }}</td>
                                    <td>{{ $item->total_jam }} Jam</td>
                                    <td>Rp {{ number_format($item->total_upah, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data lembur.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th>{{ $totalJam ?? 0 }} Jam</th>
                                <th>Rp {{ number_format($totalUpah ?? 0, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
