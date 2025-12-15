<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qr;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AbsenApiController extends Controller
{
    public function absen(Request $request, $tokenQR)
    {
        try {
            Log::info("📥 SCAN MASUK - Token diterima = {$tokenQR}");

            //-----------------------------------------------------------------
            // 1️⃣ AMBIL DATA QR
            //-----------------------------------------------------------------
            $qr = Qr::where('qr_token', $tokenQR)->first();

            if (!$qr) {
                Log::warning("❌ QR INVALID: token={$tokenQR}");
                return response()->json([
                    'success' => false,
                    'message' => 'QR tidak valid'
                ], 404);
            }

            //-----------------------------------------------------------------
            // 2️⃣ CEK QR EXPIRED
            //-----------------------------------------------------------------
            if (now()->greaterThan($qr->qr_expired_at)) {
                Log::warning("❌ QR EXPIRED: token={$tokenQR}");
                return response()->json([
                    'success' => false,
                    'message' => 'QR sudah tidak berlaku'
                ], 403);
            }

            //-----------------------------------------------------------------
            // 3️⃣ CEK WAKTU QR AKTIF
            //-----------------------------------------------------------------
            $now = Carbon::now('Asia/Jakarta');
            $jamMulai = Carbon::parse($qr->jam_mulai, 'Asia/Jakarta');
            $jamSelesai = Carbon::parse($qr->jam_selesai, 'Asia/Jakarta');

            Log::info("🕒 CEK JAM QR: now={$now}, mulai={$jamMulai}, selesai={$jamSelesai}");

            if ($now->lessThan($jamMulai)) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR belum bisa digunakan'
                ], 403);
            }

            if ($now->greaterThan($jamSelesai)) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR sudah tidak berlaku'
                ], 403);
            }

            //-----------------------------------------------------------------
            // 4️⃣ AMBIL DATA SISWA
            //-----------------------------------------------------------------
            $siswa = $request->user();
            Log::info("👤 SISWA LOGIN: id={$siswa->id}, nama={$siswa->nama}, kelas_id={$siswa->kelas_id}");

            //-----------------------------------------------------------------
            // 5️⃣ CEK KELAS SISWA SAMA DENGAN KELAS QR
            //-----------------------------------------------------------------
            if ($siswa->kelas_id != $qr->kelas_id) {
                Log::warning("❌ KELAS TIDAK SESUAI: siswa_kelas={$siswa->kelas_id}, qr_kelas={$qr->kelas_id}");
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat absen karena bukan kelas yang sesuai.'
                ], 403);
            }

            //-----------------------------------------------------------------
            // 6️⃣ CEK JADWAL SESUAI HARI & KELAS SISWA
            //-----------------------------------------------------------------
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

            Log::info("📅 CARI JADWAL: kelas_id={$siswa->kelas_id}, mapel_id={$qr->mapel_id}, hari={$hariIni}");

            $jadwal = Jadwal::where('kelas_id', $siswa->kelas_id)
                ->where('mapel_id', $qr->mapel_id)
                ->where('hari', $hariIni)
                ->first();

            if (!$jadwal) {
                Log::warning("❌ TIDAK ADA JADWAL: kelas={$siswa->kelas_id}, mapel={$qr->mapel_id}, hari={$hariIni}");
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada jadwal mapel ini untuk kelas Anda hari ini.'
                ], 403);
            }

            Log::info("📘 JADWAL DITEMUKAN: id={$jadwal->id}, mulai={$jadwal->jam_mulai}, selesai={$jadwal->jam_selesai}");

            //-----------------------------------------------------------------
            // 7️⃣ CEK JAM JADWAL (SUPPORT MELEWATI 00:00)
            //-----------------------------------------------------------------
            $mulai = Carbon::parse($jadwal->jam_mulai, 'Asia/Jakarta');
            $selesai = Carbon::parse($jadwal->jam_selesai, 'Asia/Jakarta');


            if ($selesai->lessThan($mulai)) {
                $selesai->addDay();
            }

            Log::info("🕐 CEK RANGE JAM JADWAL: now={$now}, mulai={$mulai}, selesai={$selesai}");

            if (!($now->between($mulai, $selesai))) {
                Log::warning("❌ DI LUAR JAM JADWAL: now={$now}");
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat absen di luar waktu jadwal.'
                ], 403);
            }

            //-----------------------------------------------------------------
            // 8️⃣ CEK JIKA SUDAH ABSEN HARI INI
            //-----------------------------------------------------------------
            Log::info("🔍 CEK ABSENSI SEBELUMNYA: siswa={$siswa->id}, mapel={$qr->mapel_id}");

            $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
                ->where('mapel_id', $qr->mapel_id)
                ->whereDate('waktu_absen', $now->toDateString())
                ->exists();

            if ($sudahAbsen) {
                Log::warning("❌ SUDAH ABSEN HARI INI");
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah absen untuk mapel ini hari ini'
                ], 403);
            }

            //-----------------------------------------------------------------
            // 9️⃣ SIMPAN ABSENSI
            //-----------------------------------------------------------------
            Absensi::create([
                'siswa_id' => $siswa->id,
                'mapel_id' => $qr->mapel_id,
                'kelas_id' => $qr->kelas_id,
                'qr_id' => $qr->id,
                'jadwal_id' => $jadwal->id,
                'waktu_absen' => now(),
                'status' => 'Hadir',
            ]);

            Log::info("✅ ABSEN BERHASIL: siswa={$siswa->id}, mapel={$qr->mapel_id}");

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dicatat'
            ], 200);

        } catch (\Exception $e) {
            Log::error("🔥 ERROR SERVER ABSENSI: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    // ===========================================
    // GET ABSENSI SISWA
    // ===========================================
    public function getAbsensi($nisn)
    {
        $siswa = Siswa::where('nisn', $nisn)->first();

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        $absensi = Absensi::with(['mapel', 'kelas'])
            ->where('siswa_id', $siswa->id)
            ->orderBy('waktu_absen', 'desc')
            ->get()
            ->map(function ($a) {
                return [
                    'tanggal' => $a->waktu_absen->translatedFormat('l, d F Y'),
                    'jam'     => $a->waktu_absen->format('H:i'),
                    'status'  => $a->status ?? '-',
                    'mapel'   => $a->mapel->nama ?? '-',
                    'kelas'   => $a->kelas->nama_kelas ?? '-',
                ];
            });

        $todayAbsensi = $absensi->firstWhere('tanggal', now()->translatedFormat('l, d F Y'));

        return response()->json([
            'today' => $todayAbsensi ?? [
                'tanggal' => now()->translatedFormat('l, d F Y'),
                'jam'     => '-',
                'status'  => '-',
                'mapel'   => '-',
                'kelas'   => '-',
            ],
            'riwayat' => $absensi,
        ]);
    }
}
