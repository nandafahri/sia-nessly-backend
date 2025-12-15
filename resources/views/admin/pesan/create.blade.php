@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Tambah Pesan Harian</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pesan</h6>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.pesan.store') }}">
                @csrf

                {{-- Judul Pesan --}}
                <div class="form-group">
                    <label for="judul">Judul Pesan</label>
                    <input 
                        type="text" 
                        class="form-control @error('judul') is-invalid @enderror"
                        id="judul" 
                        name="judul" 
                        value="{{ old('judul') }}" 
                        required>

                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Isi Pesan --}}
                <div class="form-group">
                    <label for="pesan">Isi Pesan</label>
                    <textarea 
                        class="form-control @error('pesan') is-invalid @enderror"
                        id="pesan" 
                        name="pesan"
                        rows="4"
                        required>{{ old('pesan') }}</textarea>

                    @error('pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <a href="{{ route('admin.pesan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>

                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>

            </form>
        </div>
    </div>

@endsection
