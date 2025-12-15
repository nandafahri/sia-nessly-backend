@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Detail Absensi Siswa</h1>

<div class="card shadow mb-4">
    <div class="card-body">

        <div class="mb-3">
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width: 200px">Nama Siswa</th>
                    <td>{{ $absensi->siswa->nama }}</td>
                </tr>
                <tr>
                    <th>NISN</th>
                    <td>{{ $absensi->siswa->nisn }}</td>
                </tr>
                <tr>
                    <th>Mata Pelajaran</th>
                    <td>{{ $absensi->mapel->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $absensi->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status Absen</th>
                    @php
                        $color = match(strtolower($absensi->status)) {
                            'hadir' => 'success',
                            'izin' => 'warning',
                            'alpha' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    <td>
                        <span class="badge badge-{{ $color }}">{{ $absensi->status }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Waktu Absen</th>
                    <td>{{ $absensi->waktu_absen->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <th>QR Token</th>
                    <td>{{ $absensi->qr->qr_token ?? '-' }}</td>
                </tr>
                <tr>
                    <th>QR Dibuat Pada</th>
                    <td>{{ optional($absensi->qr)->created_at?->format('d-m-Y H:i') ?? '-' }}</td>
                </tr>


            </tbody>
        </table>

    </div>
</div>

@endsection
