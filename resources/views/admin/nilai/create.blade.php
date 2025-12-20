@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Input Nilai Siswa</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Input Nilai</h6>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.nilai.store') }}">
            @csrf

            {{-- Siswa --}}
            <div class="form-group">
                <label>Siswa</label>
                <select name="siswa_id"
                        class="form-control @error('siswa_id') is-invalid @enderror"
                        required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswa as $s)
                        <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->nama }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mapel --}}
            <div class="form-group">
                <label>Mata Pelajaran</label>
                <select name="mapel_id"
                        class="form-control @error('mapel_id') is-invalid @enderror"
                        required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($mapel as $m)
                        <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                {{-- Jenis Nilai --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Jenis Nilai</label>
                        <select name="jenis_nilai"
                                class="form-control @error('jenis_nilai') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Jenis Nilai --</option>
                            <option value="harian" {{ old('jenis_nilai') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="uts" {{ old('jenis_nilai') == 'uts' ? 'selected' : '' }}>UTS</option>
                            <option value="uas" {{ old('jenis_nilai') == 'uas' ? 'selected' : '' }}>UAS</option>
                        </select>
                        @error('jenis_nilai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Semester --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester"
                                class="form-control @error('semester') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Semester --</option>
                            @foreach ($semesters as $s)
                                <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tahun Ajaran --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <select name="tahun_ajaran"
                                class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahun_ajaran_list as $ta)
                                <option value="{{ $ta }}" {{ old('tahun_ajaran') == $ta ? 'selected' : '' }}>
                                    {{ $ta }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Nilai Angka --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nilai Angka</label>
                        <input type="number"
                               name="nilai_angka"
                               class="form-control @error('nilai_angka') is-invalid @enderror"
                               value="{{ old('nilai_angka') }}"
                               min="0" max="100" required>
                        @error('nilai_angka')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Nilai Huruf --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nilai Huruf</label>
                        <input type="text"
                               name="nilai_huruf"
                               class="form-control @error('nilai_huruf') is-invalid @enderror"
                               value="{{ old('nilai_huruf') }}"
                               maxlength="5" required>
                        @error('nilai_huruf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Keterangan --}}
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan"
                          class="form-control @error('keterangan') is-invalid @enderror"
                          rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>

                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Nilai
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
