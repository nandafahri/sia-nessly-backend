<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Traits\LogsActivity;

class AdminProfileController extends Controller
{
    use LogsActivity;

    /**
     * Tampilkan halaman profil admin.
     */
    public function showProfile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Perbarui Nama, Email, dan Foto Profil admin.
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle upload foto profil
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder public/profile_photos
            $file->move(public_path('profile_photos'), $fileName);

            // Hapus foto lama jika ada
            if ($admin->foto_profil) {
                $oldFilePath = public_path('profile_photos/' . $admin->foto_profil);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $data['foto_profil'] = $fileName;
        }

        $oldName  = $admin->name;
        $oldEmail = $admin->email;

        $admin->update($data);

        // Log aktivitas dengan nama & email lama → baru
        $this->logActivity("Admin memperbarui profil: Nama '{$oldName}' → '{$admin->name}', Email '{$oldEmail}' → '{$admin->email}'");

        return redirect()->route('admin.profile.show')->with('success', 'Profil dan foto berhasil diperbarui!');
    }

    /**
     * Perbarui kata sandi admin.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.'])->withInput();
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        // Opsional: logout dari sesi lain
        Auth::guard('admin')->logoutOtherDevices($request->password);

        $this->logActivity("Admin memperbarui kata sandi");

        return redirect()->route('admin.profile.show')->with('success', 'Kata sandi berhasil diubah!');
    }
}
