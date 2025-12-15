@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Input Nilai Rapor Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Input Nilai</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.nilai.store') }}">
                @csrf
                
                {{-- Field Siswa --}}
                <div class="form-group">
                    <label for="siswa_id">Siswa</label>
                    <select class="form-control @error('siswa_id') is-invalid @enderror" id="siswa_id" name="siswa_id" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach ($siswa as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Mata Pelajaran --}}
                <div class="form-group">
                    <label for="mapel_id">Mata Pelajaran</label>
                    <select class="form-control @error('mapel_id') is-invalid @enderror" id="mapel_id" name="mapel_id" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option> {{-- Menggunakan kolom 'nama' --}}
                        @endforeach
                    </select>
                    @error('mapel_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if ($errors->has('mapel_id') && $errors->first('mapel_id') != $errors->get('mapel_id')[0])
                    <div class="alert alert-warning small">
                        {{ $errors->first('mapel_id') }}
                    </div>
                @endif


                <div class="row">
                    {{-- Field Semester --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select class="form-control @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                <option value="">-- Pilih Semester --</option>
                                @foreach ($semesters as $s)
                                    <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Field Tahun Ajaran --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <select class="form-control @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran" name="tahun_ajaran" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach ($tahun_ajaran_list as $ta)
                                    <option value="{{ $ta }}" {{ old('tahun_ajaran') == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Field Nilai Angka --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nilai_angka">Nilai Angka (0-100)</label>
                            <input type="number" class="form-control @error('nilai_angka') is-invalid @enderror" id="nilai_angka" name="nilai_angka" value="{{ old('nilai_angka') }}" min="0" max="100" required>
                            @error('nilai_angka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Field Nilai Huruf --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nilai_huruf">Nilai Huruf (A/B/C/D)</label>
                            <input type="text" class="form-control @error('nilai_huruf') is-invalid @enderror" id="nilai_huruf" name="nilai_huruf" value="{{ old('nilai_huruf') }}" maxlength="5" required>
                            @error('nilai_huruf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Field Keterangan --}}
                <div class="form-group">
                    <label for="keterangan">Keterangan (Opsional)</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Button Batal --}}
                <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>

                {{-- Button Update --}}
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </form>
            </form>
        </div>
    </div>

@endsection