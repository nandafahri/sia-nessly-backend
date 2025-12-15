@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Manajemen Mata Pelajaran</h1>

{{-- SWEETALERT SUCCESS --}}
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: "success",
            title: "{{ session('success') }}",
            timer: 1000,
            showConfirmButton: false
        });
    });
</script>
@endif

<div class="card shadow mb-4">

<div class="card-header py-3 d-flex justify-content-between align-items-center">

    <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Pelajaran</h6>

    <div class="d-flex align-items-center">

        {{-- SEARCH --}}
        <form action="{{ route('admin.mapel.index') }}" method="GET" class="mr-2">
            <div class="input-group input-group-sm">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control"
                    placeholder="Cari mapel / guru..."
                    value="{{ request('search') }}"
                >
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        {{-- RESET --}}
        <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary btn-sm mr-2">
            <i class="fas fa-sync"></i>
        </a>

        {{-- TAMBAH --}}
        <a href="{{ route('admin.mapel.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Mapel
        </a>

    </div>
</div>

<div class="card-body">

    <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th>No.</th>
                    <th>Nama Mapel</th>
                    <th>Guru Pengajar</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($mapel as $m)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $m->nama }}</td>
                <td>{{ $m->guru->nama ?? '-' }}</td>
                <td>

                    {{-- EDIT --}}
                    <a href="{{ route('admin.mapel.edit', $m->id) }}" 
                        class="btn btn-warning btn-sm mr-1">
                        <i class="fas fa-edit"></i>
                    </a>

                    {{-- DELETE BUTTON PAKAI SWEETALERT --}}
                    <button 
                        type="button"
                        class="btn btn-danger btn-sm btn-delete"
                        data-id="{{ $m->id }}"
                    >
                        <i class="fas fa-trash"></i>
                    </button>

                    {{-- FORM DELETE --}}
                    <form id="delete-form-{{ $m->id }}" 
                        action="{{ route('admin.mapel.destroy', $m->id) }}" 
                        method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada data mata pelajaran.</td>
            </tr>
            @endforelse
            </tbody>

        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $mapel->withQueryString()->links() }}
    </div>

</div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btn-delete').forEach(button => {

    button.addEventListener('click', function () {
        let id = this.getAttribute('data-id');
        let form = document.getElementById('delete-form-' + id);

        // Animasi kecil pada tombol
        this.classList.add("animate__animated", "animate__shakeX");

        Swal.fire({
            title: "Hapus Mapel?",
            text: "Data tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74a3b",
            cancelButtonColor: "#858796",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {

                // Submit form
                form.submit();

                // Notifikasi sukses otomatis hilang
                Swal.fire({
                    title: "Terhapus!",
                    text: "Data berhasil dihapus.",
                    icon: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
            }
        });
    });

});
</script>
@endpush
