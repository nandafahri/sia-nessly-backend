@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Manajemen Nilai Rapor Siswa</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">

        {{-- FORM CARI --}}
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Nilai Rapor</h6>

            <div class="d-flex align-items-center">
                <form action="{{ route('admin.nilai.index') }}" method="GET" class="mr-2">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari siswa / mapel / semester"
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fas fa-sync"></i>
                </a>

                <a href="{{ route('admin.nilai.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Input Nilai Baru
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Mapel</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Nilai Angka</th>
                            <th>Nilai Huruf</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($nilai as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa->nama }}</td>
                            <td>{{ $item->mapel->nama }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>

                            <td>
                                <span class="font-weight-bold {{ $item->nilai_angka < 70 ? 'text-danger' : 'text-success' }}">
                                    {{ $item->nilai_angka }}
                                </span>
                            </td>

                            <td>{{ $item->nilai_huruf }}</td>

                            <td>
                                <a href="{{ route('admin.nilai.edit', $item->id) }}"
                                    class="btn btn-warning btn-sm mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.nilai.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin hapus nilai ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>

@endsection
