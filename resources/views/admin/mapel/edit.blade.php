@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Edit Mata Pelajaran</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Mapel</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Mata Pelajaran</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $mapel->nama) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Guru Pengampu</label>
                <select name="guru_id" class="form-control" required>
                    <option value="">Pilih Guru</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ $mapel->guru_id == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</div>

@endsection
