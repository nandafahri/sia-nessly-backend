<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\LogsActivity;

class GuruController extends Controller
{
    use LogsActivity;

    // Tampilkan semua guru
    public function index(Request $request)
    {
        $query = Guru::query();

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
        }

        $gurus = $query->paginate(10)->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    // Form tambah guru
    public function create()
    {
        return view('admin.guru.create');
    }

    // Simpan guru baru
    public function store(Request $request)
    {
        $request->validate([
            'nip'     => 'required|unique:gurus',
            'nama'    => 'required',
            'telepon' => 'required|unique:gurus',
        ]);

        $guru = Guru::create($request->only(['nip', 'nama', 'telepon']));

        $this->logActivity("Admin menambahkan guru baru: {$guru->nama} (NIP: {$guru->nip})");

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    // Form edit guru
    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    // Update data guru
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip'     => 'required|unique:gurus,nip,' . $guru->id,
            'nama'    => 'required',
            'telepon' => 'required|unique:gurus,telepon,' . $guru->id,
        ]);

        $oldName = $guru->nama;
        $oldNip  = $guru->nip;

        $guru->update($request->only(['nip', 'nama', 'telepon']));

        $this->logActivity("Admin memperbarui guru: {$oldName} (NIP: {$oldNip}) menjadi {$guru->nama} (NIP: {$guru->nip})");

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    // Hapus guru
    public function destroy(Guru $guru)
    {
        $this->logActivity("Admin menghapus guru: {$guru->nama} (NIP: {$guru->nip})");

        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
