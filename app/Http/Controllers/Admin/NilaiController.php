<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;
use App\Services\NilaiAkhirService;
use App\Models\NilaiAkhir;

class NilaiController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $nilai = Nilai::with(['siswa', 'mapel'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('siswa', fn($q) =>
                    $q->where('nama', 'like', "%{$request->search}%")
                )
                ->orWhereHas('mapel', fn($q) =>
                    $q->where('nama', 'like', "%{$request->search}%")
                )
                ->orWhere('semester', 'like', "%{$request->search}%")
                ->orWhere('tahun_ajaran', 'like', "%{$request->search}%");
            })
            ->get();

        return view('admin.nilai.index', compact('nilai'));
    }

    public function create()
    {
        return view('admin.nilai.create', [
            'siswa' => Siswa::orderBy('nama')->get(),
            'mapel' => Mapel::orderBy('nama')->get(),
            'semesters' => ['Ganjil', 'Genap'],
            'tahun_ajaran_list' => collect(range(0, 4))
                ->map(fn($i) => (date('Y') - $i) . '/' . (date('Y') - $i + 1))
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapels,id',
            'jenis_nilai' => 'required|in:harian,uts,uas',
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'nilai_huruf' => 'required|string|max:5',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:15',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $exists = Nilai::where([
            'siswa_id' => $request->siswa_id,
            'mapel_id' => $request->mapel_id,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'jenis_nilai' => $request->jenis_nilai,
        ])->exists();

        if ($exists) {
            return back()->withErrors([
                'jenis_nilai' => 'Nilai dengan jenis ini sudah ada.'
            ])->withInput();
        }

        $nilai = Nilai::create($request->all());

        // 🔥 GENERATE NILAI AKHIR
        NilaiAkhirService::generate(
            $nilai->siswa_id,
            $nilai->mapel_id,
            $request->semester ?? $nilai->semester,
            $request->tahun_ajaran ?? $nilai->tahun_ajaran
        );


        $this->logActivity(
            "Admin menambahkan nilai {$nilai->jenis_nilai} siswa {$nilai->siswa->nama} mapel {$nilai->mapel->nama}"
        );

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil ditambahkan');
    }


        public function edit(Nilai $nilai)
    {
        $siswa = Siswa::orderBy('nama')->get();
        $mapel = Mapel::orderBy('nama')->get();

        $semesters = ['Ganjil', 'Genap'];

        $currentYear = date('Y');
        $tahun_ajaran_list = [];

        for ($i = 0; $i < 5; $i++) {
            $startYear = $currentYear - $i;
            $endYear = $startYear + 1;
            $tahun_ajaran_list[] = "{$startYear}/{$endYear}";
        }

        return view(
            'admin.nilai.edit',
            compact(
                'nilai',
                'siswa',
                'mapel',
                'semesters',
                'tahun_ajaran_list'
            )
        );
    }


    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'jenis_nilai' => 'required|in:harian,uts,uas',
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'nilai_huruf' => 'required|string|max:5',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:15',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $exists = Nilai::where([
            'siswa_id' => $nilai->siswa_id,
            'mapel_id' => $nilai->mapel_id,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'jenis_nilai' => $request->jenis_nilai,
        ])->where('id', '!=', $nilai->id)->exists();

        if ($exists) {
            return back()->withErrors([
                'jenis_nilai' => 'Nilai dengan jenis ini sudah ada.'
            ])->withInput();
        }

        $nilai->update($request->only([
            'jenis_nilai',
            'semester',
            'tahun_ajaran',
            'nilai_angka',
            'nilai_huruf',
            'keterangan'
        ]));

        // 🔥 UPDATE NILAI AKHIR
        NilaiAkhirService::generate(
            $nilai->siswa_id,
            $nilai->mapel_id,
            $request->semester ?? $nilai->semester,
            $request->tahun_ajaran ?? $nilai->tahun_ajaran
        );

        $this->logActivity(
            "Admin memperbarui nilai {$nilai->jenis_nilai} siswa {$nilai->siswa->nama}"
        );

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil diperbarui');
    }

    public function destroy(Nilai $nilai)
    {
        $siswaId = $nilai->siswa_id;
        $mapelId = $nilai->mapel_id;
        $semester = $nilai->semester;
        $tahunAjaran = $nilai->tahun_ajaran;

        $nilai->delete();

        // 🔥 Re-generate nilai akhir (atau hapus otomatis)
        NilaiAkhirService::generate(
            $siswaId,
            $mapelId,
            $semester,
            $tahunAjaran
        );

        $this->logActivity("Admin menghapus nilai siswa {$nilai->siswa->nama}");

        return back()->with('success', 'Nilai berhasil dihapus');
    }

}
