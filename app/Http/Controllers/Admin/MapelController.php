<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class MapelController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Mapel::with('guru');

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('guru', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
        }

        $mapel = $query->paginate(10)->withQueryString();

        return view('admin.mapel.index', compact('mapel'));
    }

    public function create()
    {
        $gurus = Guru::all();
        return view('admin.mapel.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);

        $mapel = Mapel::create($request->only(['nama', 'guru_id']));

        // Log dengan info jelas
        $guruName = $mapel->guru ? $mapel->guru->nama : 'Tanpa Guru';
        $this->logActivity("Admin menambahkan mapel \"{$mapel->nama}\" dengan guru pengajar \"{$guruName}\"");

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        $gurus = Guru::all();
        return view('admin.mapel.edit', compact('mapel', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);

        $mapel = Mapel::findOrFail($id);
        $mapel->update($request->only(['nama','guru_id']));

        $guruName = $mapel->guru ? $mapel->guru->nama : 'Tanpa Guru';
        $this->logActivity("Admin memperbarui mapel \"{$mapel->nama}\" dengan guru pengajar \"{$guruName}\"");

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran Berhasil Diupdate!');
    }

    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $guruName = $mapel->guru ? $mapel->guru->nama : 'Tanpa Guru';

        // Log sebelum dihapus agar datanya masih ada
        $this->logActivity("Admin menghapus mapel \"{$mapel->nama}\" dengan guru pengajar \"{$guruName}\"");

        $mapel->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran Berhasil Dihapus!');
    }
}
