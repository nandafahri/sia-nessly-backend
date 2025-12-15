@extends('admin.layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {{-- Judul Dashboard --}}
    <h1 class="h3 mb-0 text-gray-900 font-weight-bold">Dashboard Administrator</h1>
</div>


{{-- ======================================================= --}}
{{-- BAGIAN 1: KARTU STATISTIK (Modern & Floating Cards) --}}
{{-- ======================================================= --}}
<div class="row">
    @foreach([
        ['label'=>'Total Siswa','count'=>$siswaCount,'icon'=>'user-graduate','color'=>'success'],
        ['label'=>'Total Guru','count'=>$guruCount,'icon'=>'chalkboard-teacher','color'=>'warning'],
        ['label'=>'Total Kelas','count'=>$kelasCount,'icon'=>'graduation-cap','color'=>'primary'],
        ['label'=>'Total Mapel','count'=>$mapelCount,'icon'=>'book','color'=>'info']
    ] as $card)
    <div class="col-xl-3 col-md-6 mb-4">
        {{-- Kelas stat-card untuk efek hover scale dan shadow-lg --}}
        <div class="card shadow-lg border-0 rounded-xl stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-sm font-weight-semibold text-{{ $card['color'] }} text-uppercase mb-1">{{ $card['label'] }}</div>
                        {{-- Angka hitungan dengan font tebal --}}
                        <div class="h3 mb-0 font-weight-extrabold text-gray-900 count-up" data-count="{{ $card['count'] }}">0</div>
                    </div>
                    <div class="col-auto">
                        {{-- Ikon lebih besar dengan opacity --}}
                        <i class="fas fa-{{ $card['icon'] }} fa-3x text-{{ $card['color'] }} opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<hr class="my-5 border-gray-200">

{{-- ======================================================= --}}
{{-- BAGIAN 2: CHART + AKTIVITAS TERBARU --}}
{{-- ======================================================= --}}
<div class="row">

    {{-- Chart Perbandingan Data Utama --}}
    <div class="col-lg-6 mb-4">
        <div class="card shadow-lg border-0 rounded-xl h-100">
            {{-- Header yang lebih bersih --}}
            <div class="card-header modern-header">
                <h6 class="m-0 font-weight-bold text-primary">📊 Perbandingan Data Utama</h6>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 300px;">
                    <canvas id="myPieChart" class="rounded"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Aktivitas Terbaru (Dengan Pewarnaan Dinamis) --}}
    <div class="col-lg-6 mb-4">
        <div class="card shadow-lg border-0 rounded-xl h-100">
            <div class="card-header modern-header">
                <h6 class="m-0 font-weight-bold text-primary">⚡ Aktivitas Terbaru</h6>
            </div>
            <div class="card-body p-2">
                <div class="list-group" id="activity-list" style="max-height: 300px; overflow-y:auto;">
                    @forelse($logs as $log)
                        @php
                            // --- LOGIC PENENTUAN ICON, WARNA TEKS, DAN WARNA LATAR BELAKANG ---
                            $action = strtolower($log->action);
                            
                            // Default untuk aktivitas yang tidak terdeteksi
                            $iconClass = 'fas fa-history'; 
                            $iconColor = 'text-secondary';  
                            $bgColorClass = 'bg-secondary-subtle'; 

                            if (str_contains($action, 'menambahkan') || str_contains($action, 'tambah')) {
                                $iconClass = 'fas fa-plus-circle';
                                $iconColor = 'text-success'; 
                                $bgColorClass = 'bg-success-subtle'; // 🟢 Hijau: Buat/Tambah
                            } elseif (str_contains($action, 'menghapus') || str_contains($action, 'hapus')) {
                                $iconClass = 'fas fa-trash-alt';
                                $iconColor = 'text-danger'; 
                                $bgColorClass = 'bg-danger-subtle'; // 🔴 Merah: Hapus
                            } elseif (str_contains($action, 'mengubah') || str_contains($action, 'memperbarui') || str_contains($action, 'edit')) {
                                $iconClass = 'fas fa-edit';
                                $iconColor = 'text-warning'; 
                                $bgColorClass = 'bg-warning-subtle'; // 🟡 Kuning/Oranye: Ubah/Update
                            } elseif (str_contains($action, 'login') || str_contains($action, 'masuk') || str_contains($action, 'keluar')) {
                                $iconClass = 'fas fa-user-lock';
                                $iconColor = 'text-primary'; 
                                $bgColorClass = 'bg-primary-subtle'; // 🔵 Biru Tua: Login/System
                            } elseif (str_contains($action, 'melihat') || str_contains($action, 'detail')) {
                                $iconClass = 'fas fa-eye';
                                $iconColor = 'text-info'; 
                                $bgColorClass = 'bg-info-subtle'; // 🔹 Biru Muda: Lihat/Detail
                            }
                        @endphp

                        {{-- Item Aktivitas dengan Latar Belakang Warna Dinamis --}}
                        <div class="list-group-item activity-item {{ $bgColorClass }}">
                            <div>
                                <i class="{{ $iconClass }} {{ $iconColor }} mr-3"></i> 
                                **{{ $log->action }}**
                            </div>
                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">Belum ada aktivitas</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Global Reset dan Peningkatan Card Style */
    .card {
        border: none !important; 
        border-radius: 1.25rem !important; /* Border radius lebih besar */
        transition: all 0.3s ease-in-out;
    }

    /* Custom Shadow yang lebih modern/lembut */
    .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }

    /* Efek Hover untuk Kartu Statistik */
    .stat-card:hover {
        transform: scale(1.02); 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        cursor: pointer;
    }
    
    /* Card Header untuk Chart/Aktivitas (Clean look) */
    .modern-header {
        background-color: white !important;
        border-bottom: none !important; 
        padding-top: 1.25rem !important; 
        padding-bottom: 0.5rem !important; 
    }

    /* === DEFINISI WARNA LATAR BELAKANG SUBTLE (UNTUK AKTIVITAS) === */
    /* Menggunakan RGBA (Red, Green, Blue, Alpha) dengan Alpha 0.1 untuk warna tipis */
    
    /* Primary: Login/System */
    .bg-primary-subtle { background-color: rgba(78, 115, 223, 0.1) !important; }
    /* Success: Tambah/Buat */
    .bg-success-subtle { background-color: rgba(28, 200, 138, 0.1) !important; }
    /* Warning: Ubah/Update */
    .bg-warning-subtle { background-color: rgba(246, 194, 62, 0.1) !important; }
    /* Danger: Hapus */
    .bg-danger-subtle { background-color: rgba(231, 74, 59, 0.1) !important; }
    /* Info: Lihat/Detail */
    .bg-info-subtle { background-color: rgba(54, 185, 204, 0.1) !important; }
    /* Secondary: Default/Lain-lain */
    .bg-secondary-subtle { background-color: rgba(133, 135, 150, 0.1) !important; }

    /* STYLING ITEM AKTIVITAS TERBARU */
    #activity-list .activity-item {
        border: none;
        border-radius: 0.75rem;
        margin-bottom: 0.25rem; 
        padding: 0.75rem 1rem;
        display: flex; 
        align-items: center;
        justify-content: space-between;
        transition: background-color 0.2s ease;
    }

    /* Efek Hover untuk Warna Latar Belakang (Meningkatkan opacity saat hover) */
    .activity-item:hover { cursor: pointer; }
    .bg-primary-subtle:hover { background-color: rgba(78, 115, 223, 0.2) !important; }
    .bg-success-subtle:hover { background-color: rgba(28, 200, 138, 0.2) !important; }
    .bg-warning-subtle:hover { background-color: rgba(246, 194, 62, 0.2) !important; }
    .bg-danger-subtle:hover { background-color: rgba(231, 74, 59, 0.2) !important; }
    .bg-info-subtle:hover { background-color: rgba(54, 185, 204, 0.2) !important; }
    .bg-secondary-subtle:hover { background-color: rgba(133, 135, 150, 0.2) !important; }

    /* Konsistensi Judul */
    .h3.mb-0.font-weight-extrabold { font-size: 1.75rem; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    // Chart Data (Doughnut Chart dengan cutoutPercentage 80)
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Siswa", "Guru", "Admin"],
            datasets: [{
                data: [{{ $siswaCount }}, {{ $guruCount }}, {{ $adminCount }}],
                backgroundColor: ['#1cc88a', '#f6c23e', '#36b9cc'],
                hoverBackgroundColor: ['#17a673', '#d4aa4d', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            legend: { display: true, position: 'bottom' },
            cutoutPercentage: 80, 
        },
    });

    // Count-up animation
    document.querySelectorAll('.count-up').forEach(el => {
        let countTo = parseInt(el.dataset.count);
        let count = 0;
        let step = Math.max(1, Math.ceil(countTo / 50)); 
        let interval = setInterval(() => {
            count += step;
            if(count >= countTo){
                count = countTo;
                clearInterval(interval);
            }
            el.textContent = count.toLocaleString('id-ID'); 
        }, 20);
    });
</script>
@endpush