<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NilaiAkhir;
use Illuminate\Http\Request;

class NilaiAkhirController extends Controller
{
public function index(Request $request)
{
    $siswaId = $request->query('siswa_id');

    if (!$siswaId) {
        return response()->json([
            'success' => false,
            'message' => 'Parameter siswa_id wajib diisi'
        ], 400);
    }

    $nilaiAkhir = NilaiAkhir::with(['siswa', 'mapel'])
        ->where('siswa_id', $siswaId)
        ->orderBy('semester')
        ->get();

    return response()->json([
        'success' => true,
        'data' => $nilaiAkhir
    ]);
}

}
