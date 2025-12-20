<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Traits\LogsActivity;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    use LogsActivity;

    // ===================== LOGIN =====================
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $this->logActivity("Admin {$credentials['email']} login");
            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'Kredensial yang diberikan tidak cocok.',
        ]);
    }

// Tampilkan form input email
public function showForgotPasswordEmailForm()
{
    return view('admin.auth.forgot-password-email');
}

// Verifikasi email admin
public function verifyEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $admin = Admin::where('email', $request->email)->first();
    if (!$admin) {
        return back()->withErrors(['email' => 'Email tidak ditemukan']);
    }

    // simpan email di session sementara untuk reset password
    session(['admin_email_reset' => $admin->email]);

    return redirect()->route('admin.password.reset.form');
}

    // Tampilkan form reset password
    public function showResetForm()
    {
        if (!session()->has('admin_email_reset')) {
            return redirect()->route('admin.password.email.form')
                            ->withErrors(['email' => 'Silakan masukkan email terlebih dahulu']);
        }

        return view('admin.auth.reset-password');
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $email = session('admin_email_reset');
        $admin = Admin::where('email', $email)->first();

        if (!$admin) {
            return redirect()->route('admin.password.email.form')
                            ->withErrors(['email' => 'Admin tidak ditemukan']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        // Hapus session sementara
        session()->forget('admin_email_reset');

        return redirect()->route('admin.login.form')->with('success','Password berhasil diperbarui. Silakan login.');
    }

    // ===================== LOGOUT =====================
    public function logout(Request $request)
    {
        $adminName = Auth::guard('admin')->user()->name ?? 'Unknown';

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->logActivity("Admin {$adminName} logout");

        return redirect()->route('admin.login.form');
    }
}
