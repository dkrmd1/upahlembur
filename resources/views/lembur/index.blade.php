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
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

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
                                            <button type="button" class="btn btn-link btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#editLemburModal{{ $item->id }}" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a href="{{ route('lembur.destroy', $item->id) }}" class="btn btn-link btn-danger btn-lg delete-confirm" title="Hapus">
                                                <i class="fa fa-times"></i>
                                            </a>
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
                    <form action="{{ route('lembur.store') }}" method="POST" id="formLembur">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Tambah Lembur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Jam</label>
                                    <input type="number" name="jam" id="jumlahJam" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Upah Lembur (Rp)</label>
                                    <input type="text" id="upahField" class="form-control" disabled placeholder="Otomatis dihitung">
                                    <input type="hidden" name="upah" id="upahHidden">
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

            {{-- Modal Edit --}}
            @foreach($lemburs as $item)
            <div class="modal fade" id="editLemburModal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('lembur.update', $item->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Edit Lembur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Karyawan</label>
                                    <select name="karyawan_id" class="form-control" required>
                                        @foreach($karyawans as $kar)
                                            <option value="{{ $kar->id }}" {{ $item->karyawan_id == $kar->id ? 'selected' : '' }}>
                                                {{ $kar->nama }} ({{ $kar->nip }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Jam</label>
                                    <input type="number" name="jam" class="form-control" value="{{ $item->jam }}" required>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jamInput = document.getElementById('jumlahJam');
    const upahField = document.getElementById('upahField');
    const upahHidden = document.getElementById('upahHidden');
    const tanggalInput = document.getElementById('tanggal');
    const formLembur = document.querySelector('#formLembur');

    // Hitung upah
    if (jamInput) {
        jamInput.addEventListener('input', function () {
            const jam = parseInt(jamInput.value) || 0;
            const total = jam * 15000;
            upahField.value = total.toLocaleString('id-ID');
            upahHidden.value = total;
        });
    }

    // Validasi maksimal jam
    if (formLembur) {
        formLembur.addEventListener('submit', function (e) {
            const tanggal = new Date(tanggalInput.value);
            const jam = parseInt(jamInput.value) || 0;
            const hari = tanggal.toLocaleDateString('id-ID', { weekday: 'long' });

            const isLibur = ['Sabtu', 'Minggu'].includes(hari);
            const maxJam = isLibur ? 5 : 3;

            if (jam > maxJam) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Jam Lembur Melebihi Batas',
                    text: `Hari ${hari} hanya boleh maksimal ${maxJam} jam lembur.`
                });
            }
        });
    }

    // Konfirmasi Hapus
    document.querySelectorAll('.delete-confirm').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data tidak bisa dikembalikan!',
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
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
