@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Edit Absensi</h1>

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
        <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="siswa_id">Siswa</label>
                <select name="siswa_id" id="siswa_id" class="form-control">
                    @foreach($siswa as $s)
                        <option value="{{ $s->id }}" {{ $absensi->siswa_id == $s->id ? 'selected' : '' }}>
                            {{ $s->nama }} ({{ $s->nisn }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="mapel_id">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id" class="form-control">
                    @foreach($mapel as $m)
                        <option value="{{ $m->id }}" {{ $absensi->mapel_id == $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="kelas_id">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-control">
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $absensi->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="qr_id">QR Code</label>
                <select name="qr_id" id="qr_id" class="form-control">
                    @foreach($qrs as $q)
                        <option value="{{ $q->id }}" {{ $absensi->qr_id == $q->id ? 'selected' : '' }}>
                            {{ $q->token }} ({{ $q->created_at->format('d-m-Y H:i') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status Absen</label>
                <select name="status" id="status" class="form-control">
                    <option value="Hadir" {{ $absensi->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Izin" {{ $absensi->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Alpha" {{ $absensi->status == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Absensi</button>
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary">Kembali</a>

        </form>
    </div>
</div>

@endsection
