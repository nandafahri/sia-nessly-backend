<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Admin;
use App\Models\ActivityLog;



class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik
        $siswaCount = Siswa::count();
        $guruCount = Guru::count();
        $kelasCount = Kelas::count();
        $mapelCount = Mapel::count();
        $adminCount = Admin::count(); // Misal admin tetap 1, bisa ambil dari table admins jika ada

        $logs = ActivityLog::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'siswaCount','guruCount','adminCount','kelasCount','mapelCount','logs'
        ));
    }
}
