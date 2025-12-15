<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class SiswaController extends Controller
{
    use LogsActivity;
// Pastikan method index di controller Anda terlihat seperti ini
    public function index(Request $request)
    {
        $query = Siswa::query();

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nisn', 'like', "%{$search}%");
                // Tambahkan kondisi pencarian lain jika diperlukan,
                // seperti mencari berdasarkan nama kelas (butuh join atau with)
        }

        $siswa = $query->with('kelas')->paginate(10); // Ambil 10 data per halaman

        return view('admin.siswa.index', compact('siswa'));
    }


    public function create()
    {
        $kelas = Kelas::all(); // untuk dropdown
        return view('admin.siswa.create', compact('kelas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'email' => 'required|email|max:255|unique:siswa,email',
            'password' => 'required|string|min:8|max:20',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // proses upload foto
        $fotoPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('siswa_foto', 'public');
        }

        Siswa::create([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'foto_profil' => $fotoPath, // ← penting!
        ]);

        $this->logActivity('Admin menambahkan data siswa.');
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }


    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'nisn' => 'required|string|max:20|unique:siswa,nisn,' . $siswa->id,
            'email' => 'required|email|max:255|unique:siswa,email,' . $siswa->id,
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|max:20',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:15',
        ]);

        $data = $request->all();

        // Jika password tidak diisi, jangan diubah
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $siswa->password;
        }

        // Jika upload foto baru
        if ($request->hasFile('foto_profil')) {

            // Hapus foto lama jika ada
            if ($siswa->foto_profil && file_exists(storage_path('app/public/'.$siswa->foto_profil))) {
                unlink(storage_path('app/public/'.$siswa->foto_profil));
            }

            // Upload foto baru
            $data['foto_profil'] = $request->file('foto_profil')->store('siswa_foto', 'public');
        } else {
            // Tetap gunakan foto lama
            $data['foto_profil'] = $siswa->foto_profil;
        }

        $siswa->update($data);
        $this->logActivity('Admin memperbarui data siswa.');
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }


    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        $this->logActivity('Admin menghapus data siswa.');
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}
