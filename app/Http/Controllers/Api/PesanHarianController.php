<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PesanHarian;
use Illuminate\Http\Request;

class PesanHarianController extends Controller
{
    // GET - Ambil pesan harian terbaru
    public function index()
    {
        $pesan = PesanHarian::latest()->first();

        return response()->json([
            'status' => true,
            'message' => 'Pesan harian berhasil diambil',
            'data' => $pesan
        ]);
    }

    // POST - Tambah pesan baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'pesan' => 'required',
        ]);

        $pesan = PesanHarian::create([
            'judul' => $request->judul,
            'pesan' => $request->pesan,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pesan harian berhasil ditambahkan',
            'data' => $pesan
        ]);
    }

    // PUT - Update pesan harian
    public function update(Request $request, $id)
    {
        $pesan = PesanHarian::find($id);

        if (!$pesan) {
            return response()->json([
                'status' => false,
                'message' => 'Pesan tidak ditemukan',
            ], 404);
        }

        $pesan->update([
            'judul' => $request->judul ?? $pesan->judul,
            'pesan' => $request->pesan ?? $pesan->pesan,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pesan harian berhasil diupdate',
            'data' => $pesan
        ]);
    }

    // DELETE - Hapus pesan
    public function destroy($id)
    {
        $pesan = PesanHarian::find($id);

        if (!$pesan) {
            return response()->json([
                'status' => false,
                'message' => 'Pesan tidak ditemukan',
            ], 404);
        }

        $pesan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pesan harian berhasil dihapus'
        ]);
    }

        public function apiGetLatest()
    {
        $latest = PesanHarian::orderBy('created_at', 'desc')->first();

        return response()->json([
            'judul' => $latest->judul ?? '',
            'isi' => $latest->pesan ?? '',
            'updated_at' => $latest ? strtotime($latest->updated_at) : 0
        ]);
    }
}
