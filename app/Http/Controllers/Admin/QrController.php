<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Qr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Traits\LogsActivity;

class QrController extends Controller
{
    use LogsActivity;
    public function panel()
    {
        $mapels = Mapel::all();
        $kelas = Kelas::all();

        return view('admin.qr.panel', compact('mapels', 'kelas'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'mapel_id'   => 'required|integer',
            'kelas_id'   => 'required|integer',
            'jam_mulai'  => 'required',
            'jam_selesai'=> 'required',
        ]);

        // HAPUS QR LAMA (agar hanya 1 aktif per mapel + kelas)
        Qr::where('mapel_id', $request->mapel_id)
            ->where('kelas_id', $request->kelas_id)
            ->delete();

        // Generate token unik
        $token = uniqid();
        $url = url("/api/absen/{$token}");

        // Buat QR image
        $qrCode = QrCode::create($url)->setSize(320);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $dataUri = $result->getDataUri();

        // Hitung expire berdasarkan jam selesai
        $expire = Carbon::parse($request->jam_selesai);

        Log::info("QR GENERATE: Mapel={$request->mapel_id}, Kelas={$request->kelas_id}, Token={$token}, Expire={$expire}");

        // Simpan QR baru
        $qr = Qr::create([
            'mapel_id'       => $request->mapel_id,
            'kelas_id'       => $request->kelas_id,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'qr_token'       => $token,
            'qr_url'         => $url,
            'qr_expired_at'  => $expire,
        ]);

        return response()->json([
            'success' => true,
            'qr' => $dataUri,
            'url' => $url,
            'token' => $token,
            'expired_at' => $expire->toDateTimeString(),
        ]);

        $this->logActivity("Menghasilkan QR Code untuk mapel {$request->mapel_id} dan kelas {$request->kelas_id}");
    }
}
