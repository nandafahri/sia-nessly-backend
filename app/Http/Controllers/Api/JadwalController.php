<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->query('kelas_id');

        if (empty($kelasId)) {
            return response()->json([
                'message' => 'Parameter kelas_id wajib diisi.'
            ], 400);
        }

        try {
            $jadwal = Jadwal::where('kelas_id', $kelasId)
                ->with(['mapel', 'guru', 'kelas'])
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();

            $formattedJadwal = $jadwal->map(function ($item) {
                return [
                    'id'   => $item->id,
                    'hari' => $item->hari,

                    // Carbon → format H:i
                    'jam_mulai'   => $item->jam_mulai?->format('H:i'),
                    'jam_selesai' => $item->jam_selesai?->format('H:i'),

                    'mapel' => [
                        'id'   => $item->mapel?->id,
                        'nama' => $item->mapel?->nama ?? 'Tidak ada mapel'
                    ],

                    'kelas' => [
                        'id'   => $item->kelas?->id,
                        'nama' => $item->kelas?->nama_kelas ?? '-'
                    ],

                    // Informasi QR (optional)
                    'qr_active'     => $item->isQrActive(),
                    'qr_url'        => $item->qr_url,
                    'qr_expired_at' => $item->qr_expired_at?->toDateTimeString(),
                ];
            });

            return response()->json($formattedJadwal, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data jadwal.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
