@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Manajemen Guru</h1>

{{-- SweetAlert Sukses --}}
@if (session('success'))
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

{{-- HEADER + SEARCH --}}
<div class="card-header py-3 d-flex justify-content-between align-items-center">

    <h6 class="m-0 font-weight-bold text-primary">Daftar Guru</h6>

    <div class="d-flex align-items-center">

        {{-- SEARCH BAR --}}
        <form action="{{ route('admin.guru.index') }}" method="GET" class="mr-2">
            <div class="input-group input-group-sm">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control"
                    placeholder="Cari guru..."
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
        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary btn-sm mr-2">
            <i class="fas fa-sync"></i>
        </a>

        {{-- TAMBAH GURU --}}
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Guru
        </a>

    </div>
</div>

<div class="card-body">

    {{-- TABEL --}}
    <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th>No.</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($gurus as $g)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $g->nip }}</td>
                    <td>{{ $g->nama }}</td>
                    <td>{{ $g->telepon }}</td>
                    <td>

                        {{-- BUTTON EDIT --}}
                        <a href="{{ route('admin.guru.edit', $g->id) }}" 
                            class="btn btn-warning btn-sm mr-1">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- DELETE BUTTON (memanggil SweetAlert) --}}
                        <button 
                            class="btn btn-danger btn-sm btnDelete"
                            data-id="{{ $g->id }}"
                            data-nama="{{ $g->nama }}"
                        >
                            <i class="fas fa-trash"></i>
                        </button>

                        {{-- FORM DELETE HIDDEN --}}
                        <form id="deleteForm{{ $g->id }}" 
                              action="{{ route('admin.guru.destroy', $g->id) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data guru.</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center">
        {{ $gurus->withQueryString()->links() }}
    </div>

</div>

</div>

@endsection


{{-- SWEETALERT DELETE SCRIPT --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btnDelete').forEach(btn => {
    btn.addEventListener('click', function() {

        let id = this.getAttribute('data-id');
        let nama = this.getAttribute('data-nama');
        let form = document.getElementById('deleteForm' + id);

        Swal.fire({
            title: "Hapus Guru?",
            text: "Guru " + nama + " akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74a3b",
            cancelButtonColor: "#858796",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {

                // Animasi spinner loading
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                btn.disabled = true;

                form.submit();
            }
        });
    });
});
</script>
@endpush
