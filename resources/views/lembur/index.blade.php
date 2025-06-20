@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="col-md-12">
        <div class="card">

            {{-- Header --}}
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Data Lembur</h4>
                <button class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#addLemburModal">
                    <i class="fa fa-plus"></i> Tambah Lembur
                </button>
            </div>

            {{-- Body --}}
            <div class="card-body">
                {{-- Alert --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Upah</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lemburs as $item)
                                @php
                                    $hari = \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd');
                                    $isLibur = in_array($hari, ['Sabtu', 'Minggu']);
                                @endphp
                                <tr>
                                    <td>{{ $item->karyawan->nama ?? '-' }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                        <span class="{{ $isLibur ? 'text-danger fw-bold' : '' }}">
                                            {{ $hari }} {{ $isLibur ? '(Libur)' : '(Kerja)' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->jam }} jam</td>
                                    <td>Rp {{ number_format($item->upah, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('lembur.edit', $item->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('lembur.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-link btn-danger btn-lg" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data lembur.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th>{{ $totalJam }} jam</th>
                                <th colspan="2">Rp {{ number_format($totalUpah, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Modal Tambah --}}
            <div class="modal fade" id="addLemburModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('lembur.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title"><span class="fw-mediumbold">Tambah</span> <span class="fw-light">Lembur</span></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Karyawan</label>
                                    <select name="karyawan_id" class="form-control" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}">{{ $karyawan->nama }} ({{ $karyawan->nip }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Jam</label>
                                    <input type="number" name="jam" id="jumlahJam" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Upah Lembur (Rp)</label>
                                    <input type="text" id="upahField" class="form-control" disabled placeholder="Otomatis dihitung">
                                    <input type="hidden" name="upah" id="upahHidden">
                                    <small class="form-text text-muted">Rp15.000 × jumlah jam</small>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jamInput = document.getElementById('jumlahJam');
        const upahField = document.getElementById('upahField');
        const upahHidden = document.getElementById('upahHidden');

        jamInput.addEventListener('input', function () {
            const jam = parseInt(jamInput.value) || 0;
            const total = jam * 15000;
            upahField.value = total.toLocaleString('id-ID');
            upahHidden.value = total;
        });
    });
</script>
@endpush
