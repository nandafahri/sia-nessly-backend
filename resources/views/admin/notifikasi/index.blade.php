@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Daftar Notifikasi</h1>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">

        {{-- HEADER --}}
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            
            <h6 class="m-0 font-weight-bold text-primary">Data Notifikasi</h6>

            <div class="d-flex align-items-center">

                {{-- SEARCH --}}
                <form action="{{ route('admin.notifikasi.index') }}" method="GET" class="mr-2">
                    <div class="input-group input-group-sm">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control"
                            placeholder="Cari notifikasi..."
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
                <a href="{{ route('admin.notifikasi.index') }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fas fa-sync"></i>
                </a>

                {{-- TAMBAH --}}
                <a href="{{ route('admin.notifikasi.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                </a>

            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No.</th>
                            <th width="80">Emoji</th>
                            <th>Teks</th>
                            <th width="140">Tanggal</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $n)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="font-size: 26px">{{ $n->emoji }}</td>
                            <td>{{ $n->teks }}</td>
                            <td>{{ $n->created_at->format('d M Y') }}</td>

                            <td class="text-center">

                                {{-- EDIT --}}
                                <a href="{{ route('admin.notifikasi.edit', $n->id) }}" 
                                   class="btn btn-warning btn-sm mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- DELETE BUTTON (SweetAlert) --}}
                                <button 
                                    type="button"
                                    class="btn btn-danger btn-sm btn-delete"
                                    data-id="{{ $n->id }}"
                                    data-name="{{ $n->teks }}"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>

                                {{-- FORM DELETE --}}
                                <form id="delete-form-{{ $n->id }}"
                                      action="{{ route('admin.notifikasi.destroy', $n->id) }}"
                                      method="POST" 
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada notifikasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center">
                {{ $data->appends(['search' => request('search')])->links() }}
            </div>

        </div>
    </div>

@endsection


{{-- ====================================== --}}
{{-- SWEETALERT SCRIPT KHUSUS DELETE --}}
{{-- ====================================== --}}
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
            title: "Hapus Notifikasi?",
            text: "Notifikasi: \"" + name + "\" akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74a3b",
            cancelButtonColor: "#858796",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {

            if (result.isConfirmed) {

                form.submit();

                Swal.fire({
                    icon: "success",
                    title: "Berhasil Dihapus",
                    text: "Notifikasi telah dihapus.",
                    timer: 1000,
                    showConfirmButton: false
                });

            }
        });

    });

});
</script>

@endpush
