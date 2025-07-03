@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Kelola Akun</h4>
                <div class="d-flex">
                    <form method="GET" action="{{ route('users.index') }}" class="me-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau NIP..." value="{{ request('search') }}">
                    </form>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fa fa-plus"></i> Tambah User
                    </button>
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIP</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->nip ?? '-' }}</td>
                                <td><span class="badge bg-info text-white">{{ ucfirst($user->role) }}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-sm btn-danger delete-confirm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label>NIP</label>
                                                    <input type="text" name="nip" class="form-control" value="{{ $user->nip }}" required>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label>Role</label>
                                                    <select name="role" class="form-control">
                                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label>Password (kosongkan jika tidak diganti)</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <tr><td colspan="5" class="text-center">Belum ada user</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Tambah -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>NIP</label>
                                    <input type="text" name="nip" class="form-control" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Role</label>
                                    <select name="role" class="form-control" required>
                                        <option value="admin">Admin</option>
                                        <option value="manager">Manager</option>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary">Simpan</button>
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
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.delete-confirm').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus'
                }).then(result => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        form.innerHTML = `
                            @csrf
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
