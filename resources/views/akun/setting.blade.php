@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="d-flex align-items-left flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Pengaturan Akun</h3>
            <h6 class="op-7 mb-2">Edit profil dan ganti password akun Anda</h6>
        </div>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="row">
        {{-- Form Edit Profil --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bold">Edit Profil</div>
                <div class="card-body">
                    <form action="{{ route('akun.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="form" value="edit">

                        <div class="form-group mb-3">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload Avatar --}}
                        <div class="form-group mb-3">
                            <label for="avatar">Foto Profil (Avatar)</label>
                            <input type="file" name="avatar" id="avatar"
                                   class="form-control @error('avatar') is-invalid @enderror"
                                   accept="image/*">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user->avatar)
                                <div class="mt-3 text-center">
                                    <p>Avatar Saat Ini:</p>
                                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
                                         alt="Avatar"
                                         class="img-thumbnail shadow-sm"
                                         style="max-height: 100px; max-width: 100px; object-fit: contain;">
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Profil</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Form Ganti Password --}}
        <div class="col-md-6 mt-4 mt-md-0">
            <div class="card">
                <div class="card-header fw-bold">Ganti Password</div>
                <div class="card-body">
                    <form action="{{ route('akun.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="form" value="password">

                        <div class="form-group mb-3">
                            <label for="password">Password Baru</label>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror">
                        </div>

                        <button type="submit" class="btn btn-warning">Ganti Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
