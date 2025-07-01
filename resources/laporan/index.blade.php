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
            <label for="karyawan_id" class="form-label">Karyawan (opsional)</label>
            <select name="karyawan_id" class="form-select">
                <option value="">-- Semua Karyawan --</option>
                @foreach($karyawans as $kar)
                    <option value="{{ $kar->id }}" {{ request('karyawan_id') == $kar->id ? 'selected' : '' }}>
                        {{ $kar->nama }} - {{ $kar->nip }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-info">Tampilkan</button>
        </div>
    </form>

    @if($lemburData->count())
    <div class="mb-3">
        <strong>Total Jam:</strong> {{ $totalJam }} jam <br>
        <strong>Total Upah:</strong> Rp {{ number_format($totalUpah, 0, ',', '.') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Upah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lemburData as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->karyawan->nama }}</td>
                    <td>{{ $item->karyawan->nip }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->hari }}</td>
                    <td>{{ $item->jam }} jam</td>
                    <td>Rp {{ number_format($item->upah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data lembur untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
