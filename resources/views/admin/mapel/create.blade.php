@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Tambah Mata Pelajaran</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Mapel</h6>
    </div>

<div class="card-body">
    <form action="{{ route('admin.mapel.store') }}" method="POST">
        @csrf

        {{-- Nama Mata Pelajaran --}}
        <div class="mb-3">
            <label class="form-label">Nama Mata Pelajaran</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                value="{{ old('nama') }}" placeholder="Contoh: Matematika" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Guru Pengajar --}}
        <div class="mb-3">
            <label class="form-label">Guru Pengajar</label>
            <select name="guru_id" class="form-control @error('guru_id') is-invalid @enderror" required>
                <option value="">-- Pilih Guru Pengajar --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
            @error('guru_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol --}}
        <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Batal
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
    </form>
</div>


</div>

@endsection
