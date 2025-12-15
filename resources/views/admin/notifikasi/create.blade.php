@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Tambah Notifikasi Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Notifikasi</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.notifikasi.store') }}" method="POST">
                @csrf

                {{-- Emoji --}}
                <div class="form-group">
                    <label for="emoji">Emoji (opsional)</label>
                    <input 
                        type="text" 
                        id="emoji" 
                        name="emoji" 
                        class="form-control @error('emoji') is-invalid @enderror"
                        placeholder="Contoh: 🔔"
                        value="{{ old('emoji') }}"
                    >
                    @error('emoji') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>

                {{-- Teks Notifikasi --}}
                <div class="form-group">
                    <label for="teks">Teks Notifikasi</label>
                    <textarea 
                        id="teks" 
                        name="teks" 
                        rows="3" 
                        class="form-control @error('teks') is-invalid @enderror"
                        required>{{ old('teks') }}</textarea>

                    @error('teks') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>

                {{-- Button Batal --}}
                <a href="{{ route('admin.notifikasi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>

                {{-- Button Simpan --}}
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>

            </form>
        </div>
    </div>

@endsection
