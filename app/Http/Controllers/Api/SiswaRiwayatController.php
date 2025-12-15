<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiswaRiwayatController extends Controller
{
    public function riwayat()
    {
        $siswa = Auth::user();

        $data = $siswa->absensi()
            ->with(['qr.mapel', 'qr.kelas'])
            ->latest()
            ->get()
            ->map(function ($absen) {
                return [
                    'mapel' => $absen->qr->mapel->nama,
                    'kelas' => $absen->qr->kelas->nama,
                    'waktu' => $absen->waktu_absen,
                    'status' => $absen->status,
                    'keterangan' => $absen->keterangan,
                ];
            });

        return response()->json([
            'success' => true,
            'riwayat' => $data,
        ]);
    }
}
