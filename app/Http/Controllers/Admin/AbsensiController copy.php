<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Qr;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use App\Traits\LogsActivity;

class AbsensiController extends Controller
{
    use LogsActivity;
    // Tampilkan daftar absensi
    public function index(Request $request)
    {
        $query = Absensi::with(['siswa', 'mapel', 'kelas']);

        if ($request->search) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $absensi = $query->paginate(10);

        return view('admin.absensi.index', compact('absensi'));
    }
    // Tampilkan form create
    public function create()
    {
        $siswa = Siswa::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        $qrs   = Qr::all();

        return view('admin.absensi.create', compact('siswa', 'mapel', 'kelas', 'qrs'));
    }

    // Simpan data absensi baru
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'status'   => 'required|string',
            'qr_id'    => 'required|exists:qrs,id',
        ]);

        $absensi = Absensi::create([
            'siswa_id'    => $request->siswa_id,
            'mapel_id'    => $request->mapel_id,
            'kelas_id'    => $request->kelas_id,
            'status'      => $request->status,
            'waktu_absen' => now(),
            'qr_id'       => $request->qr_id,
        ]);

        // Catat aktivitas
        $this->logActivity("Menambahkan absensi siswa {$absensi->siswa->nama} ({$absensi->siswa->nisn})");

        return redirect()->route('admin.absensi.index')
                         ->with('success', 'Absensi berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit(Absensi $absensi)
    {
        $siswa = Siswa::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        $qrs   = Qr::all();

        return view('admin.absensi.edit', compact('absensi', 'siswa', 'mapel', 'kelas', 'qrs'));
    }

    // Update absensi
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'status'   => 'required|string',
            'qr_id'    => 'required|exists:qrs,id',
        ]);

        $absensi->update([
            'siswa_id'    => $request->siswa_id,
            'mapel_id'    => $request->mapel_id,
            'kelas_id'    => $request->kelas_id,
            'status'      => $request->status,
            'qr_id'       => $request->qr_id,
        ]);

        // Catat aktivitas
        $this->logActivity("Memperbarui absensi siswa {$absensi->siswa->nama} ({$absensi->siswa->nisn})");

        return redirect()->route('admin.absensi.index')
                         ->with('success', 'Absensi berhasil diperbarui!');
    }

    // Hapus absensi
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        // Catat aktivitas

        $this->logActivity("Menghapus absensi siswa {$absensi->siswa->nama} ({$absensi->siswa->nisn})");

        return redirect()->route('admin.absensi.index')
                         ->with('success', 'Absensi berhasil dihapus!');
    }

    // Tampilkan detail absensi
    public function show(Absensi $absensi)
    {
        // Catat aktivitas melihat detail
        $this->logActivity("Melihat detail absensi siswa {$absensi->siswa->nama} ({$absensi->siswa->nisn})");



        return view('admin.absensi.show', compact('absensi'));
    }

    // Export ke Excel
    public function export()
    {
        // Catat aktivitas
        ActivityLog::create([
            'user_type' => 'Admin',
            'user_name' => auth()->guard('admin')->user()->name ?? 'Admin',
            'action'    => "Mengekspor data absensi ke Excel",
        ]);

        $this->logActivity("Mengekspor data absensi ke Excel");

        return Excel::download(new AbsensiExport, 'absensi.xlsx');
    }
}
