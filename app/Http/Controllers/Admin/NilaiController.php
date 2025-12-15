<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Siswa; 
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class NilaiController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $search = $request->search;

        $nilai = Nilai::with(['siswa', 'mapel'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })
                ->orWhereHas('mapel', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })
                ->orWhere('semester', 'like', "%$search%")
                ->orWhere('tahun_ajaran', 'like', "%$search%");
            })
            ->get();

        return view('admin.nilai.index', compact('nilai'));
    }

    public function create()
    {
        $siswa = Siswa::orderBy('nama')->get();
        $mapel = Mapel::orderBy('nama')->get();

        $semesters = ['Ganjil', 'Genap'];
        $currentYear = date('Y');
        $tahun_ajaran_list = [];
        for ($i = 0; $i < 5; $i++) {
            $startYear = $currentYear - $i;
            $endYear = $startYear + 1;
            $tahun_ajaran_list[] = $startYear . '/' . $endYear;
        }

        return view('admin.nilai.create', compact('siswa', 'mapel', 'semesters', 'tahun_ajaran_list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapels,id',
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'nilai_huruf' => 'required|string|max:5',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:15',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        // Cek duplikasi
        $existing = Nilai::where('siswa_id', $request->siswa_id)
                         ->where('mapel_id', $request->mapel_id)
                         ->where('semester', $request->semester)
                         ->where('tahun_ajaran', $request->tahun_ajaran)
                         ->first();
                         
        if ($existing) {
            return back()->withInput()->withErrors(['mapel_id' => 'Nilai Mata Pelajaran ini sudah diinput untuk semester dan tahun ajaran yang sama.']);
        }

        $nilai = Nilai::create($request->all());

        // Log dengan info jelas
        $this->logActivity("Admin menambahkan nilai siswa \"{$nilai->siswa->nama}\" untuk mapel \"{$nilai->mapel->nama}\" (Semester: {$nilai->semester}, Tahun: {$nilai->tahun_ajaran})");

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai siswa berhasil ditambahkan!');
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
            $tahun_ajaran_list[] = $startYear . '/' . $endYear;
        }

        return view('admin.nilai.edit', compact('nilai', 'siswa', 'mapel', 'semesters', 'tahun_ajaran_list'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapels,id',
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'nilai_huruf' => 'required|string|max:5',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:15',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        // Cek duplikasi saat update
        $existing = Nilai::where('siswa_id', $request->siswa_id)
                         ->where('mapel_id', $request->mapel_id)
                         ->where('semester', $request->semester)
                         ->where('tahun_ajaran', $request->tahun_ajaran)
                         ->where('id', '!=', $nilai->id)
                         ->first();
                         
        if ($existing) {
            return back()->withInput()->withErrors(['mapel_id' => 'Nilai Mata Pelajaran ini sudah diinput untuk semester dan tahun ajaran yang sama.']);
        }

        $nilai->update($request->all());

        $this->logActivity("Admin memperbarui nilai siswa \"{$nilai->siswa->nama}\" untuk mapel \"{$nilai->mapel->nama}\" (Semester: {$nilai->semester}, Tahun: {$nilai->tahun_ajaran})");

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai siswa berhasil diperbarui!');
    }

    public function destroy(Nilai $nilai)
    {
        $this->logActivity("Admin menghapus nilai siswa \"{$nilai->siswa->nama}\" untuk mapel \"{$nilai->mapel->nama}\" (Semester: {$nilai->semester}, Tahun: {$nilai->tahun_ajaran})");

        $nilai->delete();

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil dihapus!');
    }
}
