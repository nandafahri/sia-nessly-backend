@extends('admin.layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Daftar Pesan Harian</h1>

{{-- ALERT SUKSES (HILANG OTOMATIS SWEETALERT) --}}
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: '{{ session("success") }}',
        timer: 1200,
        showConfirmButton: false
    });
</script>
@endif

<div class="card shadow mb-4">

    {{-- HEADER --}}
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Pesan Harian</h6>

        <div class="d-flex align-items-center">

            {{-- SEARCH --}}
            <form action="{{ route('admin.pesan.index') }}" method="GET" class="mr-2">
                <div class="input-group input-group-sm">
                    <input 
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari pesan..."
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
            <a href="{{ route('admin.pesan.index') }}" class="btn btn-secondary btn-sm mr-2">
                <i class="fas fa-sync"></i>
            </a>

            {{-- TAMBAH --}}
            <a href="{{ route('admin.pesan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pesan
            </a>

        </div>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th style="width: 120px">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ Str::limit($item->pesan, 60) }}</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>

                        <td>

                            {{-- EDIT --}}
                            <a href="{{ route('admin.pesan.edit', $item->id) }}" 
                                class="btn btn-warning btn-sm mr-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- DELETE (SweetAlert) --}}
                            <button 
                                class="btn btn-danger btn-sm btn-delete"
                                data-id="{{ $item->id }}"
                                data-action="{{ route('admin.pesan.destroy', $item->id) }}"
                            >
                                <i class="fas fa-trash"></i>
                            </button>

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada pesan harian.</td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</div>


{{-- =========================== --}}
{{--  SWEETALERT DELETE HANDLER  --}}
{{-- =========================== --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".btn-delete").forEach(btn => {

        btn.addEventListener("click", function () {
            
            let id = this.dataset.id;
            let action = this.dataset.action;
            let button = this;

            Swal.fire({
                title: "Hapus Pesan?",
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e74a3b",
                cancelButtonColor: "#858796",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {

                    // Animasi tombol (spin)
                    button.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
                    button.disabled = true;

                    // Submit form via POST (create form otomatis)
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

@endsection
