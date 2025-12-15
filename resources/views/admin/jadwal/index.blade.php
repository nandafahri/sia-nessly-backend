@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Manajemen Jadwal Pelajaran</h1>

{{-- Pesan sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Pelajaran</h6>

        <div class="d-flex">
            {{-- FORM CARI --}}
            <form action="{{ route('admin.jadwal.index') }}" method="GET" class="mr-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari kelas/mapel/hari"
                           value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            {{-- RESET --}}
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary btn-sm mr-2">
                <i class="fas fa-sync"></i>
            </a>

            {{-- TAMBAH --}}
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jadwals as $j)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $j->kelas->nama_kelas }}</td>
                        <td>{{ $j->mapel->nama }}</td>
                        <td>{{ $j->hari }}</td>
                        <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>

                        <td>

                            {{-- EDIT --}}
                            <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- DELETE BUTTON PAKAI SWEETALERT --}}
                            <button 
                                type="button"
                                class="btn btn-danger btn-sm btn-delete"
                                data-id="{{ $j->id }}"
                                data-name="{{ $j->mapel->nama }}"
                            >
                                <i class="fas fa-trash"></i>
                            </button>

                            {{-- FORM DELETE --}}
                            <form id="delete-form-{{ $j->id }}"
                                  action="{{ route('admin.jadwal.destroy', $j->id) }}"
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data jadwal pelajaran.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>

@endsection


{{-- ========================== --}}
{{-- SWEETALERT DELETE SCRIPT --}}
{{-- ========================== --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btn-delete').forEach(btn => {

    btn.addEventListener('click', function () {

        let id = this.dataset.id;
        let name = this.dataset.name;
        let form = document.getElementById('delete-form-' + id);

        // Animasi tombol
        this.classList.add("animate__animated", "animate__shakeX");

        Swal.fire({
            title: "Hapus Jadwal?",
            text: "Jadwal pelajaran '" + name + "' akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74a3b",
            cancelButtonColor: "#858796",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {

            if (result.isConfirmed) {

                form.submit();

                Swal.fire({
                    icon: "success",
                    title: "Berhasil Dihapus",
                    text: "Data jadwal telah dihapus.",
                    timer: 1000,
                    showConfirmButton: false
                });

            }
        });
    });

});
</script>
@endpush
