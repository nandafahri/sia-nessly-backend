<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Absensi::with(['siswa', 'mapel', 'kelas'])
            ->get()
            ->map(function($a) {
                return [
                    'Nama Siswa' => $a->siswa->nama,
                    'NISN' => $a->siswa->nisn,
                    'Mata Pelajaran' => $a->mapel->nama ?? '-',
                    'Kelas' => $a->kelas->nama_kelas ?? '-',
                    'Waktu Absen' => $a->waktu_absen->format('d-m-Y H:i'),
                    'Status' => $a->status,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Siswa', 'NISN', 'Mata Pelajaran', 'Kelas', 'Waktu Absen', 'Status'];
    }
}
