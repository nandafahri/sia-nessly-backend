@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Tambah Jadwal Pelajaran</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Formulir Penambahan Jadwal</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.jadwal.store') }}" method="POST">
            @csrf

            {{-- Pesan Error Validasi (Opsional) --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 1. Kelas --}}
            <div class="form-group">
                <label for="kelas_id">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- 2. Mata Pelajaran --}}
            <div class="form-group mt-3">
                <label for="mapel_id">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id" class="form-control @error('mapel_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $m)
                        <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- 3. Hari --}}
            <div class="form-group mt-3">
                <label for="hari">Hari</label>
                <select name="hari" id="hari" class="form-control @error('hari') is-invalid @enderror" required>
                    <option value="">-- Pilih Hari --</option>
                    @php
                        $hari_options = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    @endphp
                    @foreach($hari_options as $h)
                        <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
                @error('hari')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- 4. Jam Mulai --}}
            <div class="form-group mt-3">
                <label for="jam_mulai">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai') }}" required>
                @error('jam_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- 5. Jam Selesai --}}
            <div class="form-group mt-3">
                <label for="jam_selesai">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai') }}" required>
                @error('jam_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        {{-- Tombol --}}
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Batal
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
        </form>
    </div>
</div>

@endsection