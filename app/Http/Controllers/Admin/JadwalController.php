<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class JadwalController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $search = $request->search;

        $jadwals = Jadwal::with(['kelas', 'mapel'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('kelas', function ($cls) use ($search) {
                        $cls->where('nama_kelas', 'like', "%$search%");
                    })
                  ->orWhereHas('mapel', function ($mp) use ($search) {
                        $mp->where('nama', 'like', "%$search%");
                    })
                  ->orWhere('hari', 'like', "%$search%");
            })
            ->get();

        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        return view('admin.jadwal.create', compact('kelas', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'    => 'required|exists:kelas,id',
            'mapel_id'    => 'required|exists:mapels,id',
            'hari'        => 'required|string|max:20',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $data = $request->all();
        $data['jam_mulai']   = $request->jam_mulai . ':00';
        $data['jam_selesai'] = $request->jam_selesai . ':00';

        $jadwal = Jadwal::create($data);

        $this->logActivity("Admin menambahkan jadwal: Kelas \"{$jadwal->kelas->nama_kelas}\" - Mata Pelajaran \"{$jadwal->mapel->nama}\" pada hari \"{$jadwal->hari}\"");

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }


    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $kelas = Kelas::all();
        $mapels = Mapel::all();

        return view('admin.jadwal.edit', compact('jadwal', 'kelas', 'mapels'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id'    => 'required|exists:kelas,id',
            'mapel_id'    => 'required|exists:mapels,id',
            'hari'        => 'required|string|max:20',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        // Format jam agar sesuai database (HH:MM:SS)
        $data = $request->all();
        $data['jam_mulai']   = $request->jam_mulai . ':00';
        $data['jam_selesai'] = $request->jam_selesai . ':00';

        $jadwal->update($data);

        $this->logActivity("Admin memperbarui jadwal: Kelas \"{$jadwal->kelas->nama_kelas}\" - Mata Pelajaran \"{$jadwal->mapel->nama}\" pada hari \"{$jadwal->hari}\"");

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }


    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $this->logActivity("Admin menghapus jadwal: Kelas \"{$jadwal->kelas->nama_kelas}\" - Mata Pelajaran \"{$jadwal->mapel->nama}\" pada hari \"{$jadwal->hari}\"");

        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
