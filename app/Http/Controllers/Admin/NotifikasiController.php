<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class NotifikasiController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $search = $request->search;

        $data = Notifikasi::when($search, function ($query) use ($search) {
                    $query->where('teks', 'like', "%$search%")
                        ->orWhere('emoji', 'like', "%$search%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

        return view('admin.notifikasi.index', compact('data'));
    }

    public function create()
    {
        return view('admin.notifikasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'emoji' => 'nullable|string',
            'teks'  => 'required|string',
        ]);

        $notif = Notifikasi::create($request->only(['emoji', 'teks']));

        // Log dengan isi notifikasi yang jelas
        $this->logActivity("Admin menambahkan notifikasi: " . ($notif->emoji ? $notif->emoji . ' ' : '') . "\"{$notif->teks}\"");

        return redirect()->route('admin.notifikasi.index')
                         ->with('success', 'Notifikasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $notif = Notifikasi::findOrFail($id);
        return view('admin.notifikasi.edit', compact('notif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'emoji' => 'nullable|string',
            'teks'  => 'required|string',
        ]);

        $notif = Notifikasi::findOrFail($id);
        $notif->update($request->only(['emoji', 'teks']));

        $this->logActivity("Admin mengubah notifikasi menjadi: " . ($notif->emoji ? $notif->emoji . ' ' : '') . "\"{$notif->teks}\"");

        return redirect()->route('admin.notifikasi.index')
                         ->with('success', 'Notifikasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $notif = Notifikasi::findOrFail($id);

        // Log sebelum dihapus
        $this->logActivity("Admin menghapus notifikasi: " . ($notif->emoji ? $notif->emoji . ' ' : '') . "\"{$notif->teks}\"");

        $notif->delete();

        return redirect()->route('admin.notifikasi.index')
                         ->with('success', 'Notifikasi berhasil dihapus.');
    }
}
