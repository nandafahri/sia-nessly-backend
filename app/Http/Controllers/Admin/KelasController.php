<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\LogsActivity;

class KelasController extends Controller
{
    use LogsActivity;

    // Tampilkan daftar kelas
    public function index(Request $request)
    {
        $query = Kelas::with('waliKelas'); // eager load relasi waliKelas

        if ($search = $request->input('search')) {
            $query->where('nama_kelas', 'like', "%{$search}%")
                ->orWhere('tingkat', 'like', "%{$search}%")
                ->orWhere('jurusan', 'like', "%{$search}%")
                ->orWhereHas('waliKelas', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
        }

        $kelas = $query->orderBy('nama_kelas')->paginate(15)->withQueryString();

        return view('admin.kelas.index', compact('kelas'));
    }

    // Form tambah kelas
    public function create()
    {
        $gurus = Guru::orderBy('nama')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    // Simpan kelas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat'    => 'required|in:10,11,12',
            'jurusan'    => 'nullable|string|max:255',
            'guru_id'    => 'nullable|exists:gurus,id',
        ]);

        $kelas = Kelas::create([
            'nama_kelas'    => $request->nama_kelas,
            'tingkat'       => $request->tingkat,
            'jurusan'       => $request->jurusan,
            'wali_kelas_id' => $request->guru_id,
        ]);

        // Eager load relasi untuk log
        $kelas->load('waliKelas');
        $waliNama = $kelas->waliKelas?->nama ?? '-';
        $this->logActivity("Admin menambahkan kelas {$kelas->nama_kelas} dengan wali kelas: {$waliNama}");

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    // Form edit kelas
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $gurus = Guru::orderBy('nama')->get();
        return view('admin.kelas.edit', compact('kelas', 'gurus'));
    }

    // Update kelas
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat'    => 'required|in:10,11,12',
            'jurusan'    => 'nullable|string|max:255',
            'guru_id'    => 'nullable|exists:gurus,id',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas'    => $request->nama_kelas,
            'tingkat'       => $request->tingkat,
            'jurusan'       => $request->jurusan,
            'wali_kelas_id' => $request->guru_id,
        ]);

        // Eager load relasi untuk log
        $kelas->load('waliKelas');
        $waliNama = $kelas->waliKelas?->nama ?? '-';
        $this->logActivity("Admin memperbarui kelas {$kelas->nama_kelas} dengan wali kelas: {$waliNama}");

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    // Hapus kelas
    public function destroy($id)
    {
        $kelas = Kelas::with('waliKelas')->findOrFail($id);
        $namaKelas = $kelas->nama_kelas;
        $waliNama   = $kelas->waliKelas?->nama ?? '-';
        $kelas->delete();

        $this->logActivity("Admin menghapus kelas {$namaKelas} dengan wali kelas: {$waliNama}");

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
