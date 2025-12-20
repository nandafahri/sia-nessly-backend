@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Manajemen Nilai Siswa</h1>

{{-- ALERT --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<div class="card shadow mb-4">

    {{-- HEADER + FILTER --}}
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="m-0 font-weight-bold text-primary">Data Nilai</h6>

        <form action="{{ route('admin.nilai.index') }}" method="GET" class="form-inline">

            <input type="text"
                   name="search"
                   class="form-control form-control-sm mr-2"
                   placeholder="Cari siswa / mapel"
                   value="{{ request('search') }}">

            <select name="jenis_nilai" class="form-control form-control-sm mr-2">
                <option value="">Semua Jenis</option>
                <option value="harian" {{ request('jenis_nilai') == 'harian' ? 'selected' : '' }}>Harian</option>
                <option value="uts" {{ request('jenis_nilai') == 'uts' ? 'selected' : '' }}>UTS</option>
                <option value="uas" {{ request('jenis_nilai') == 'uas' ? 'selected' : '' }}>UAS</option>
            </select>

            <select name="semester" class="form-control form-control-sm mr-2">
                <option value="">Semua Semester</option>
                <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>

            <button class="btn btn-primary btn-sm mr-2">
                <i class="fas fa-filter"></i>
            </button>

            <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary btn-sm mr-2">
                <i class="fas fa-sync"></i>
            </a>

            <a href="{{ route('admin.nilai.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Input Nilai
            </a>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Mapel</th>
                        <th>Jenis</th>
                        <th>Semester</th>
                        <th>Tahun Ajaran</th>
                        <th>Nilai</th>
                        <th>Huruf</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($nilai as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->siswa->nama }}</td>
                        <td>{{ $item->mapel->nama }}</td>

                        <td>
                            <span class="badge badge-info text-uppercase">
                                {{ $item->jenis_nilai }}
                            </span>
                        </td>

                        <td>{{ $item->semester }}</td>
                        <td>{{ $item->tahun_ajaran }}</td>

                        <td>
                            <span class="font-weight-bold
                                {{ $item->nilai_angka < 70 ? 'text-danger' : 'text-success' }}">
                                {{ $item->nilai_angka }}
                            </span>
                        </td>

                        <td>{{ $item->nilai_huruf }}</td>

                        <td>
                            <a href="{{ route('admin.nilai.edit', $item->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.nilai.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus nilai ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Tidak ada data nilai ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINATION --}}

        </div>
    </div>

</div>

@endsection
