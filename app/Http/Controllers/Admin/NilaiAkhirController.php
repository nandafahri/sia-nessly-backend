<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NilaiAkhir;

class NilaiAkhirController extends Controller
{
    public function index()
    {
        $nilaiAkhir = NilaiAkhir::with(['siswa', 'mapel'])
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester')
            ->get();

        return view('admin.nilai_akhir.index', compact('nilaiAkhir'));
    }
}
