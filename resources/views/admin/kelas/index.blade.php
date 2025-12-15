@extends('admin.layouts.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Daftar Kelas</h1>

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        
        {{-- HEADER --}}
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            
            <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>

            <div class="d-flex align-items-center">

                {{-- SEARCH BAR --}}
                <form action="{{ route('admin.kelas.index') }}" method="GET" class="mr-2">
                    <div class="input-group input-group-sm">
                        <input 
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari kelas..."
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
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fas fa-sync"></i>
                </a>

                {{-- TAMBAH --}}
                <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Kelas
                </a>

            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th style="width: 120px">Aksi</th>
                        </tr> 
                    </thead>
                    <tbody>
                        @forelse ($kelas as $kela)
                        <tr>
                            <td>{{ $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() }}</td>
                            <td>{{ $kela->nama_kelas }}</td>
                            <td>{{ $kela->tingkat }}</td>
                            <td>{{ $kela->jurusan ?? '-' }}</td>
                            <td>{{ $kela->waliKelas->nama ?? 'Belum ada' }}</td>

                            <td>
                                {{-- Edit --}}
                                <a href="{{ route('admin.kelas.edit', $kela->id) }}" class="btn btn-warning btn-sm mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                {{-- Delete dengan SweetAlert --}}
                                <form action="{{ route('admin.kelas.destroy', $kela->id) }}" 
                                      method="POST" 
                                      class="d-inline deleteForm">

                                    @csrf
                                    @method('DELETE')
                                    
                                    <button type="submit" class="btn btn-danger btn-sm btnDelete" data-name="{{ $kela->nama_kelas }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data kelas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINASI --}}
            <div class="d-flex justify-content-center">
                {{ $kelas->appends(['search' => request('search')])->links() }}
            </div>

        </div>
    </div>

@endsection

{{-- SCRIPT SWEETALERT DELETE --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btnDelete').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault(); 

        const form = this.closest('form');
        const name = this.getAttribute('data-name');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Kelas: " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    });
});
</script>
@endpush
