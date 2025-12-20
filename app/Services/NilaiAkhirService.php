<?php

namespace App\Services;

namespace App\Services;

use App\Models\Nilai;
use App\Models\NilaiAkhir;

class NilaiAkhirService
{
    public static function generate(
        int $siswaId,
        int $mapelId,
        string $semester,
        string $tahunAjaran
    ): void {

        $nilai = Nilai::where('siswa_id', $siswaId)
            ->where('mapel_id', $mapelId)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get();

        // 🔥 JIKA TIDAK ADA NILAI SAMA SEKALI
        if ($nilai->isEmpty()) {
            NilaiAkhir::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelId,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                ],
                [
                    'nilai_harian' => 0,
                    'nilai_uts'    => 0,
                    'nilai_uas'    => 0,
                    'nilai_akhir'  => 0,
                    'nilai_huruf'  => 'D',
                ]
            );
            return;
        }

        $harian = $nilai->where('jenis_nilai', 'harian')->avg('nilai_angka') ?? 0;
        $uts    = $nilai->where('jenis_nilai', 'uts')->avg('nilai_angka') ?? 0;
        $uas    = $nilai->where('jenis_nilai', 'uas')->avg('nilai_angka') ?? 0;

        $nilaiAkhir = ($harian * 0.4) + ($uts * 0.3) + ($uas * 0.3);

        $huruf = match (true) {
            $nilaiAkhir >= 90 => 'A',
            $nilaiAkhir >= 80 => 'B',
            $nilaiAkhir >= 70 => 'C',
            default => 'D'
        };

        NilaiAkhir::updateOrCreate(
            [
                'siswa_id' => $siswaId,
                'mapel_id' => $mapelId,
                'semester' => $semester,
                'tahun_ajaran' => $tahunAjaran,
            ],
            [
                'nilai_harian' => round($harian, 2),
                'nilai_uts'    => round($uts, 2),
                'nilai_uas'    => round($uas, 2),
                'nilai_akhir'  => round($nilaiAkhir, 2),
                'nilai_huruf'  => $huruf,
            ]
        );
    }
}
