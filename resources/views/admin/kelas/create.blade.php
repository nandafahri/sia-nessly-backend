@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Tambah Kelas Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kelas</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.kelas.store') }}">
                @csrf

                {{-- Nama Kelas --}}
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror"
                           id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" required>
                    @error('nama_kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Tingkat --}}
                <div class="form-group">
                    <label for="tingkat">Tingkat</label>
                    <select class="form-control @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                        <option value="">Pilih Tingkat</option>
                        <option value="10" {{ old('tingkat') == '10' ? 'selected' : '' }}>10</option>
                        <option value="11" {{ old('tingkat') == '11' ? 'selected' : '' }}>11</option>
                        <option value="12" {{ old('tingkat') == '12' ? 'selected' : '' }}>12</option>
                    </select>
                    @error('tingkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Jurusan --}}
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan">
                        <option value="">Pilih Jurusan</option>
                        <option value="Rekayasa Perangkat Lunak" {{ old('jurusan') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                        <option value="Teknik Komputer Jaringan" {{ old('jurusan') == 'Teknik Komputer Jaringan' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                        <option value="Multimedia" {{ old('jurusan') == 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                    </select>
                    @error('jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Wali Kelas (dropdown dari $gurus) --}}
                <div class="form-group">
                    <label for="guru_id">Wali Kelas</label>
                    <select name="guru_id" id="guru_id" class="form-control @error('guru_id') is-invalid @enderror">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }} ({{ $guru->nip ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('guru_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            {{-- Button Batal --}}
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>

            {{-- Button Update --}}
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            </form>
        </div>
    </div>

@endsection
