<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Brand Sidebar (Logo/Nama Aplikasi) --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon"> {{-- Hapus rotate-n-15 --}}
            {{-- Menggunakan icon Font Awesome yang lebih umum sebagai logo --}}
            <img src="{{ asset('admin/img/logo_sma.png') }}" alt="Logo SMA" style="width: 40px; height: 40px; object-fit: contain;">        
        </div>
        {{-- Menambahkan teks "Sistem Informasi" di samping "Admin" --}}
        <div class="sidebar-brand-text mx-3">SISFO Admin</div> 
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item {{ (request()->routeIs('admin.dashboard')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manajemen Data
    </div>

    {{-- 1. SISWA --}}
    <li class="nav-item {{ (request()->routeIs('admin.siswa.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.siswa.index') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Siswa</span></a>
    </li>
    
    {{-- 2. KELAS (TAMBAHAN BARU) --}}
    <li class="nav-item {{ (request()->routeIs('admin.kelas.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kelas.index') }}">
            <i class="fas fa-fw fa-door-open"></i> {{-- Icon Kelas/Ruangan --}}
            <span>Kelas</span></a>
    </li>

    {{-- 3. GURU (TAMBAHAN BARU) --}}
    <li class="nav-item {{ (request()->routeIs('admin.guru.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.guru.index') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i> {{-- Icon Guru/Pengajar --}}
            <span>Guru</span>
        </a>
    </li>

    {{-- 4. MATA PELAJARAN --}}
    <li class="nav-item {{ (request()->routeIs('admin.mapel.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.mapel.index') }}">
            <i class="fas fa-fw fa-book"></i> {{-- Icon Mata Pelajaran --}}
            <span>Mata Pelajaran</span></a>
    </li>


    {{-- 6. NILAI --}}
    <li class="nav-item {{ (request()->routeIs('admin.nilai.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.nilai.index') }}">
            <i class="fas fa-fw fa-chart-bar"></i> {{-- Icon Chart yang lebih sesuai untuk Nilai --}}
            <span>Nilai</span></a>
    </li>

    {{-- 7. JADWAL --}}
    <li class="nav-item {{ (request()->routeIs('admin.jadwal.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.jadwal.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i> {{-- Icon Kalender/Jadwal --}}
            <span>Jadwal</span></a>
    </li>

    {{-- 8. NOTIFIKASI --}}
    <li class="nav-item {{ (request()->routeIs('admin.notifikasi.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.notifikasi.index') }}">
            <i class="fas fa-fw fa-bell"></i> {{-- Icon Bell/Notifikasi --}}
            <span>Notifikasi</span></a>
    </li>

    {{-- 9. PESAN HARIAN --}}
    <li class="nav-item {{ (request()->routeIs('admin.pesan.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pesan.index') }}">
            <i class="fas fa-fw fa-comment-dots"></i> {{-- Icon Comment/Dots --}}
            <span>Pesan Harian</span></a>
    </li>
    {{-- 8. ABSENSI --}}
    <li class="nav-item {{ (request()->routeIs('admin.absensi.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.absensi.index') }}">
            <i class="fas fa-fw fa-calendar-check"></i> {{-- Icon Calendar Check --}}
            <span>Absensi</span></a>
    </li>

    {{-- 10. QR CODE --}}
    <li class="nav-item {{ (request()->routeIs('admin.qr.*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.qr.panel') }}">
            <i class="fas fa-fw fa-qrcode"></i> {{-- Icon QR Code --}}
            <span>QR Code</span></a>
    </li>




    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>