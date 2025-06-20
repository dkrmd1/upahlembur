@extends('layouts.main')

@section('container')
<div class="page-inner">
    <h4 class="fw-bold mb-3">Laporan Lembur</h4>

    <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label for="bulan" class="form-label">Bulan</label>
            <select name="bulan" id="bulan" class="form-select">
                @foreach(range(1, 12) as $b)
                    <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($b)->locale('id')->monthName }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" value="{{ request('tahun', date('Y')) }}">
        </div>
        <div class="col-md-3">
            <button class="btn btn-info">Tampilkan</button>
        </div>
    </form>

    {{-- contoh tabel hasil laporan --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Karyawan</th>
                    <th>Total Jam</th>
                    <th>Total Upah</th>
                </tr>
            </thead>
            <tbody>
                {{-- tampilkan hasil rekap dari controller --}}
                @forelse ($laporan as $i => $data)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->total_jam }} jam</td>
                    <td>Rp {{ number_format($data->total_upah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
