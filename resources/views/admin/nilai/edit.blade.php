@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Edit Nilai Rapor</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Nilai</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.nilai.update', $nilai->id) }}">
                @csrf
                @method('PUT')
                
                {{-- Field Siswa (Disabled - Tampilkan Nama Siswa saja) --}}
                <div class="form-group">
                    <label for="siswa_id">Siswa</label>
                    <input type="text" class="form-control" value="{{ $nilai->siswa->nama }}" disabled>
                    {{-- Hidden field untuk mengirim ID siswa --}}
                    <input type="hidden" name="siswa_id" value="{{ $nilai->siswa_id }}">
                </div>

                {{-- Field Mata Pelajaran (Disabled - Tampilkan Nama Mapel saja) --}}
                <div class="form-group">
                    <label for="mapel_id">Mata Pelajaran</label>
                    <input type="text" class="form-control" value="{{ $nilai->mapel->nama }}" disabled>
                    {{-- Hidden field untuk mengirim ID mapel --}}
                    <input type="hidden" name="mapel_id" value="{{ $nilai->mapel_id }}">
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
                                    <option value="{{ $s }}" {{ old('semester', $nilai->semester) == $s ? 'selected' : '' }}>{{ $s }}</option>
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
                                    <option value="{{ $ta }}" {{ old('tahun_ajaran', $nilai->tahun_ajaran) == $ta ? 'selected' : '' }}>{{ $ta }}</option>
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
                            <input type="number" class="form-control @error('nilai_angka') is-invalid @enderror" id="nilai_angka" name="nilai_angka" value="{{ old('nilai_angka', $nilai->nilai_angka) }}" min="0" max="100" required>
                            @error('nilai_angka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Field Nilai Huruf --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nilai_huruf">Nilai Huruf (A/B/C/D)</label>
                            <input type="text" class="form-control @error('nilai_huruf') is-invalid @enderror" id="nilai_huruf" name="nilai_huruf" value="{{ old('nilai_huruf', $nilai->nilai_huruf) }}" maxlength="5" required>
                            @error('nilai_huruf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Field Keterangan --}}
                <div class="form-group">
                    <label for="keterangan">Keterangan (Opsional)</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $nilai->keterangan) }}</textarea>
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
                    <i class="fas fa-save"></i> Update
                </button>
            </form>
        </div>
    </div>

@endsection