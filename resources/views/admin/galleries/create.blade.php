@extends('layouts.admin')

@section('title', 'Tambah Galeri Baru')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle"></i> Tambah Galeri Baru</h1>
        <a href="{{ route('dashboard.galleries.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Galeri
        </a>
    </div>

    <!-- Alert untuk Error -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oops!</strong> Ada masalah dengan input Anda.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-accent text-white">
            <h5 class="mb-0"><i class="fas fa-pen"></i> Form Tambah Galeri</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.galleries.store') }}" method="POST">
                @csrf

                <!-- Input Judul -->
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Galeri:</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul galeri" value="{{ old('title') }}" required>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('dashboard.galleries.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
