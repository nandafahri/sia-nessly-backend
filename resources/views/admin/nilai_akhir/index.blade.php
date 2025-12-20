@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">📊 Nilai Akhir Siswa</h1>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Nilai Akhir
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Mata Pelajaran</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Harian</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Nilai Akhir</th>
                            <th>Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilaiAkhir as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $item->siswa->nama ?? '-' }}</td>
                            <td class="text-left">{{ $item->mapel->nama ?? '-' }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td>{{ $item->nilai_harian }}</td>
                            <td>{{ $item->nilai_uts }}</td>
                            <td>{{ $item->nilai_uas }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $item->nilai_akhir }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $color = match($item->nilai_huruf){
                                        'A'=>'success',
                                        'B'=>'primary',
                                        'C'=>'warning',
                                        default=>'danger'
                                    };
                                @endphp
                                <span class="badge badge-{{ $color }}">
                                    {{ $item->nilai_huruf }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                Data nilai akhir belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
