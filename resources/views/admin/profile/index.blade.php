{{-- resources/views/admin/profile/index.blade.php --}}

@extends('admin.layouts.app')

@section('content')

    {{-- Header dengan Ikon --}}
    <h1 class="h3 mb-4 text-gray-900 font-weight-bold">👤 Profil Administrator</h1>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-lg" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-lg" role="alert">
            <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        
        {{-- ======================================================= --}}
        {{-- KIRI: Form Update Profil dan Foto --}}
        {{-- ======================================================= --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-0 rounded-xl h-100">
                <div class="card-header py-3 modern-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Tampilan Foto Profil Saat Ini/Preview --}}
                        <div class="form-group text-center mb-4">
                            <label class="d-block font-weight-semibold text-gray-700">Foto Profil</label>
                            <div class="mb-3">
                                {{-- Penambahan shadow dan border agar lebih modern --}}
                                <img id="profile-picture-preview" 
                                    src="{{ $admin->foto_profil 
                                        ? asset('profile_photos/' . $admin->foto_profil) 
                                        : asset('admin/img/undraw_profile.svg') }}"
                                    alt="Foto Profil" 
                                    class="profile-img-preview">
                            </div>
                        </div>

                        {{-- Input Upload Foto --}}
                        <div class="form-group">
                            <label for="foto_profil">Unggah Foto Profil Baru</label>
                            <input type="file" class="form-control-file form-control-modern @error('foto_profil') is-invalid @enderror" id="foto_profil" name="foto_profil">
                            <small class="form-text text-muted">Maksimal 2MB. Format: JPG, PNG. (Klik foto di atas untuk melihat preview)</small>
                            @error('foto_profil')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="my-4">

                        {{-- Field Nama --}}
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control form-control-modern @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Field Email --}}
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-modern @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BUTTON SIMPAN --}}
                        <button type="submit" class="btn btn-primary btn-block mt-4 rounded-lg shadow-sm">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ======================================================= --}}
        {{-- KANAN: Form Ubah Kata Sandi --}}
        {{-- ======================================================= --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-0 rounded-xl h-100">
                <div class="card-header py-3 modern-header">
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Kata Sandi</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control form-control-modern @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Kata Sandi Baru</label>
                            <input type="password" class="form-control form-control-modern @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control form-control-modern" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-4 rounded-lg shadow-sm">Ubah Kata Sandi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Global Card Style Modern */
    .card {
        border: none !important;
        transition: all 0.3s ease-in-out;
    }
    .rounded-xl {
        border-radius: 1.25rem !important; /* Radius lebih besar */
    }
    .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    .modern-header {
        background-color: white !important;
        border-bottom: none !important; /* Hapus garis tebal header */
        padding-bottom: 0.5rem !important;
    }

    /* Styling Input Fields Modern */
    .form-control-modern {
        border-radius: 0.75rem !important; /* Input field lebih rounded */
        padding: 0.75rem 1rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control-modern:focus {
        border-color: #4e73df; /* Warna primary saat fokus */
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    .form-control-file.form-control-modern {
        /* Styling khusus untuk input file agar terlihat konsisten */
        padding: 0.375rem 1rem;
    }

    /* Styling Foto Profil Preview */
    .profile-img-preview {
        width: 150px; 
        height: 150px; 
        object-fit: cover; 
        border-radius: 50%;
        border: 4px solid #f8f9fc; /* Border putih tipis */
        box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Shadow ringan pada foto */
        transition: all 0.3s ease;
    }
    .profile-img-preview:hover {
        transform: scale(1.03);
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
</style>
@endpush

@push('scripts')
<script>
    // Fungsi untuk menampilkan preview gambar
    document.getElementById('foto_profil').onchange = function (evt) {
        const [file] = evt.target.files
        if (file) {
            document.getElementById('profile-picture-preview').src = URL.createObjectURL(file)
        }
    }
</script>
@endpush


