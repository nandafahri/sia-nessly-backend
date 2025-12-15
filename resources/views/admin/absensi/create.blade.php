@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Tambah Absensi</h1>

{{-- Pesan Error --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.absensi.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="siswa_id">Siswa</label>
                <select name="siswa_id" id="siswa_id" class="form-control">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->nama }} ({{ $s->nisn }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="mapel_id">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id" class="form-control">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapel as $m)
                        <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="kelas_id">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-control">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="qr_id">QR Code</label>
                <select name="qr_id" id="qr_id" class="form-control">
                    <option value="">-- Pilih QR --</option>
                    @foreach($qrs as $q)
                        <option value="{{ $q->id }}" {{ old('qr_id') == $q->id ? 'selected' : '' }}>
                            {{ $q->token }} ({{ $q->created_at->format('d-m-Y H:i') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status Absen</label>
                <select name="status" id="status" class="form-control">
                    <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Alpha" {{ old('status') == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Absensi</button>
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary">Kembali</a>

        </form>
    </div>
</div>

@endsection
