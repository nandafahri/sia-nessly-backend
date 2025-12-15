@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Edit Pesan Harian: {{ $pesan->judul }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Pesan Harian</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.pesan.update', $pesan->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Field Judul --}}
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input 
                        type="text" 
                        class="form-control @error('judul') is-invalid @enderror" 
                        id="judul" 
                        name="judul" 
                        value="{{ old('judul', $pesan->judul) }}" 
                        required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Isi Pesan --}}
                <div class="form-group">
                    <label for="pesan">Isi Pesan</label>
                    <textarea 
                        id="pesan" 
                        name="pesan" 
                        class="form-control @error('pesan') is-invalid @enderror" 
                        rows="4" 
                        required>{{ old('pesan', $pesan->pesan) }}</textarea>
                    @error('pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Button Batal --}}
                <a href="{{ route('admin.pesan.index') }}" class="btn btn-secondary">
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
