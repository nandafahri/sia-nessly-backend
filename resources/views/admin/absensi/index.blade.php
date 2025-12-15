@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">History Absensi Siswa</h1>

{{-- SweetAlert Sukses --}}
@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 1200,
                showConfirmButton: false
            });
        });
    </script>
@endif


<div class="card shadow mb-4">

{{-- HEADER --}}
<div class="card-header py-3 d-flex justify-content-between align-items-center">

    {{-- Judul --}}
    <h6 class="m-0 font-weight-bold text-primary">Data Absensi</h6>

    {{-- Action Buttons --}}
    <div class="d-flex align-items-center">

        {{-- SEARCH BAR --}}
        <form action="{{ route('admin.absensi.index') }}" method="GET" class="mr-2">
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control"
                       value="{{ request()->query('search') }}" 
                       placeholder="Cari nama atau NISN...">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button> 
                </div>
            </div>
        </form>

        {{-- RESET --}}
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary btn-sm mr-2">
            <i class="fas fa-sync"></i>
        </a>

        {{-- EXPORT --}}
        <a href="{{ route('admin.absensi.export') }}" class="btn btn-success btn-sm mr-2">
            <i class="fas fa-file-export"></i> Export
        </a>

        {{-- TAMBAH --}}
        <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Absensi
        </a>

    </div>
</div>


{{-- BODY --}}
<div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Waktu Absen</th>
                        <th>Status</th>
                        <th width="110px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($absensi as $a)
                    <tr>
                        <td>{{ $loop->iteration + ($absensi->currentPage() - 1) * $absensi->perPage() }}</td>
                        <td>{{ $a->siswa->nama }}</td>
                        <td>{{ $a->siswa->nisn }}</td>
                        <td>{{ $a->mapel->nama ?? '-' }}</td>
                        <td>{{ $a->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $a->waktu_absen->format('d-m-Y H:i') }}</td>

                        <td>
                            @php
                                $color = match(strtolower($a->status)) {
                                    'hadir' => 'success',
                                    'izin' => 'warning',
                                    'alpha' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-{{ $color }}">{{ ucfirst($a->status) }}</span>
                        </td>

                        <td class="d-flex">
                            <a href="{{ route('admin.absensi.show', $a->id) }}" class="btn btn-info btn-sm mr-1">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.absensi.edit', $a->id) }}" class="btn btn-warning btn-sm mr-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('admin.absensi.destroy', $a->id) }}" 
                                  method="POST" class="form-delete d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn btn-danger btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data absensi</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $absensi->appends(request()->query())->links() }}
        </div>

    </div>
</div>

@endsection


{{-- ========================================= --}}
{{-- SWEETALERT SCRIPT (di luar content)       --}}
{{-- ========================================= --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function (e) {

            let form = this.closest('form');

            Swal.fire({
                title: "Hapus Data?",
                text: "Data absensi akan dihapus permanen.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#858796",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });
    });

});
</script>
@endpush
