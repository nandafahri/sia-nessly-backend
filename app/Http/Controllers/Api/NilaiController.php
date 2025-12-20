<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Services\NilaiAkhirService;



class NilaiController extends Controller
{
    /**
     * GET /api/nilai?siswa_id=1
     */
    public function index(Request $request)
    {
        $siswaId = $request->query('siswa_id');

        if (!$siswaId) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter siswa_id wajib diisi.'
            ], 400);
        }

        try {
            // Ambil nilai + join mapel
            $nilai = Nilai::with('mapel')
                ->where('siswa_id', $siswaId)
                ->orderBy('semester', 'asc')
                ->orderBy('mapel_id', 'asc')
                ->get();

            if ($nilai->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data nilai tidak ditemukan',
                    'data' => []
                ], 200);
            }

            // Format JSON hasil
            $formatted = $nilai->map(function ($n) {
                return [
                    'id'            => $n->id,
                    'semester'      => $n->semester,
                    'tahun_ajaran'  => $n->tahun_ajaran,
                    'nilai_angka'   => $n->nilai_angka,
                    'nilai_huruf'   => $n->nilai_huruf,
                    'keterangan'    => $n->keterangan,
                    'mapel' => [
                        'id'   => $n->mapel?->id,
                        'nama' => $n->mapel?->nama ?? "Tidak diketahui"
                    ]
                ];
            });

            return response()->json([
                "success" => true,
                "data" => $formatted
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data nilai.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

}
