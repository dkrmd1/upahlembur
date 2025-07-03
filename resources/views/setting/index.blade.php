@extends('layouts.main')

@section('container')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Setting Website</h3>
            <h6 class="op-7 mb-2">Pengaturan judul dan logo website</h6>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Form Setting --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Input Judul Website --}}
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Judul Website</label>
                    <input type="text" name="title" id="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $setting->title ?? '') }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload Logo --}}
                <div class="form-group mb-3">
                    <label for="logo" class="form-label">Upload Logo</label>
                    <input type="file" name="logo" id="logo"
                           class="form-control @error('logo') is-invalid @enderror"
                           accept="image/*">
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Preview Logo Saat Ini --}}
                    @if (!empty($setting->logo))
                        <div class="mt-3">
                            <p>Logo Saat Ini:</p>
                            <div class="border p-2 d-inline-block" style="background-color: #f9f9f9;">
                                <img src="{{ asset('storage/logo/' . $setting->logo) }}"
                                     alt="Logo Website"
                                     style="width:127px; height:33px; display:block; object-fit:contain;">
                            </div>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>
</div>
@endsection
