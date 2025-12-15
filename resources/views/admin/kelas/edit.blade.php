@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Edit Kelas: {{ $kelas->nama_kelas }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Kelas</h6>
        </div>
        <div class="card-body">
            {{-- Menggunakan $kela (sesuai penamaan di Controller) --}}
            <form method="POST" action="{{ route('admin.kelas.update', $kelas->id) }}">
                @csrf
                @method('PUT')
                
                {{-- Field Nama Kelas --}}
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                    @error('nama_kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Tingkat --}}
                <div class="form-group">
                    <label for="tingkat">Tingkat</label>
                    <input type="text" class="form-control @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" value="{{ old('tingkat', $kelas->tingkat) }}" required>
                    @error('tingkat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Jurusan --}}
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" value="{{ old('jurusan', $kelas->jurusan) }}" required>
                    @error('jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                <i class="fas fa-save"></i> Update
            </button>
            </form>
        </div>
    </div>

@endsection