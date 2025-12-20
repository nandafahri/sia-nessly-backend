<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Absensi;
use Carbon\Carbon;

class StatusAbsensiController extends Controller
{
    // ===========================================
    // JUMLAH JADWAL HARI INI
    // ===========================================
    public function jumlahJadwalHariIni($nisn)
    {
        $siswa = Siswa::where('nisn', $nisn)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $hariInggris = Carbon::now('Asia/Jakarta')->format('l');

        $mappingHari = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $hariIni = $mappingHari[$hariInggris];

        $jumlah = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->count();

        return response()->json([
            'success' => true,
            'jumlah' => $jumlah
        ]);
    }

    // ===========================================
    // JUMLAH ABSENSI HARI INI
    // ===========================================
    public function jumlahAbsensiHariIni($nisn)
    {
        $siswa = Siswa::where('nisn', $nisn)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $today = Carbon::now('Asia/Jakarta')->toDateString();

        $jumlah = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('waktu_absen', $today)
            ->count();

        return response()->json([
            'success' => true,
            'jumlah' => $jumlah
        ]);
    }
}
