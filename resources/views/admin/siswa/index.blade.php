@extends('admin.layouts.app')

@section('content')

{{-- SWEETALERT SUCCESS --}}
@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 1300,
                showConfirmButton: false
            });
        });
    </script>
@endif

<h1 class="h3 mb-4 text-gray-800">Manajemen Data Siswa</h1>

<div class="card shadow-sm mb-4">

    {{-- HEADER MODERN --}}
    <div class="card-header card-modern-header d-flex justify-content-between align-items-center">

        <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>

        <div class="d-flex align-items-center">

            {{-- SEARCH --}}
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="mr-2">
                <div class="input-group input-group-sm">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control input-search-modern"
                        placeholder="Cari siswa..."
                        value="{{ request('search') }}"
                    >
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-modern" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            {{-- RESET --}}
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary btn-sm mr-2">
                <i class="fas fa-sync"></i>
            </a>

            {{-- TAMBAH --}}
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-plus"></i> Tambah Siswa
            </a>
        </div>

    </div>

    {{-- BODY --}}
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-modern" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>NISN</th>
                        <th>Email</th>
                        <th>Foto</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th style="width:120px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama ?? 'N/A' }}</td>
                        <td>{{ $item->jenis_kelamin ?? 'N/A' }}</td>
                        <td>{{ $item->nisn ?? 'N/A' }}</td>
                        <td>{{ $item->email ?? 'N/A' }}</td>

                        <td>
                            <img 
                                src="{{ $item->foto_profil 
                                    ? asset('storage/' . $item->foto_profil) 
                                    : asset('admin/img/default_profile.png') }}" 
                                class="rounded-circle img-student">
                        </td>

                        <td>{{ $item->kelas->nama_kelas ?? 'N/A' }}</td>
                        <td>{{ $item->alamat ?? 'N/A' }}</td>
                        <td>{{ $item->nomor_telepon ?? 'N/A' }}</td>

                        <td class="text-center">

                            {{-- EDIT --}}
                            <a href="{{ route('admin.siswa.edit', $item->id) }}" 
                               class="btn btn-warning btn-action mr-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- DELETE --}}
                            <button 
                                class="btn btn-danger btn-action btn-delete"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->nama }}"
                                data-action="{{ route('admin.siswa.destroy', $item->id) }}"
                            >
                                <i class="fas fa-trash"></i>
                            </button>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">Belum ada data siswa.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $siswa->withQueryString()->links() }}
        </div>

    </div>
</div>

@endsection


{{-- SCRIPT HARUS DI LUAR SECTION CONTENT AGAR TIDAK MERUSAK LAYOUT --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".btn-delete").forEach(btn => {

        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let name = this.dataset.name;
            let action = this.dataset.action;
            let button = this;

            Swal.fire({
                title: "Hapus Siswa?",
                text: "Data siswa '" + name + "' akan dihapus permanen.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e74a3b",
                cancelButtonColor: "#858796",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {

                if (result.isConfirmed) {

                    // Animasi spinner
                    button.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
                    button.disabled = true;

                    // Submit form dinamis
                    let form = document.createElement("form");
                    form.method = "POST";
                    form.action = action;

                    let csrf = document.createElement("input");
                    csrf.type = "hidden";
                    csrf.name = "_token";
                    csrf.value = "{{ csrf_token() }}";

                    let method = document.createElement("input");
                    method.type = "hidden";
                    method.name = "_method";
                    method.value = "DELETE";

                    form.appendChild(csrf);
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });

        });

    });

});
</script>
@endpush
