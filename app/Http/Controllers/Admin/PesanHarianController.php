<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PesanHarian;
use App\Traits\LogsActivity;

class PesanHarianController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $data = PesanHarian::orderBy('created_at', 'desc')->get();
        return view('admin.pesan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pesan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'pesan' => 'required',
        ]);

        PesanHarian::create($request->only('judul', 'pesan'));
        $this->logActivity("Admin menambahkan data pesan harian dengan judul {$request->judul}");

        return redirect()->route('admin.pesan.index')
            ->with('success', 'Pesan harian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pesan = PesanHarian::findOrFail($id);
        return view('admin.pesan.edit', compact('pesan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'pesan' => 'required',
        ]);

        $pesan = PesanHarian::findOrFail($id);
        $pesan->update($request->only('judul', 'pesan'));
        $this->logActivity("Admin mengupdate data pesan harian dengan judul {$request->judul}");
        return redirect()->route('admin.pesan.index')
            ->with('success', 'Pesan harian berhasil diupdate');
    }

    public function destroy($id)
    {
        $pesan = PesanHarian::findOrFail($id);
        $pesan->delete();

        $this->logActivity("Admin menghapus data pesan harian dengan judul {$pesan->judul}");
        return redirect()->route('admin.pesan.index')
            ->with('success', 'Pesan harian berhasil dihapus');
    }


}
