@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Edit Data Guru</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Guru</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" value="{{ $guru->nip }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" value="{{ $guru->nama }}" class="form-control">
            </div>


            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="telepon" value="{{ $guru->telepon }}" class="form-control">
            </div>
            {{-- Button Batal --}}
            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>

            {{-- Button Simpan --}}
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</div>

@endsection
