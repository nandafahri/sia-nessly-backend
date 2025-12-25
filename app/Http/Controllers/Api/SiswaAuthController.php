<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

// class SiswaAuthController extends Controller
// {
//     /**
//      * Mendaftarkan Siswa baru.
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function register(Request $request)
//     {
//         // 1. Validasi input
//         $request->validate([
//             'nama' => 'required|string|max:150',
//             // 'nisn' harus unik di tabel 'siswa'
//             'nisn' => 'required|string|unique:siswa,nisn',
//             'password' => 'required|string|min:8',
//             // 'kelas_id' harus ada di tabel 'kelas'
//             'kelas_id' => 'required|exists:kelas,id',
//             'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
//             'alamat' => 'nullable|string',
//             'nomor_telepon' => 'nullable|string|max:15',
//         ]);

//         // 2. Buat record Siswa baru
//         $siswa = Siswa::create([
//             'nama' => $request->nama,
//             'nisn' => $request->nisn,
//             // Menggunakan Hash::make() untuk konsistensi
//             'password' => Hash::make($request->password), 
//             'kelas_id' => $request->kelas_id,
//             'jenis_kelamin' => $request->jenis_kelamin,
//             'alamat' => $request->alamat,
//             'nomor_telepon' => $request->nomor_telepon,
//         ]);

//         // 3. Muat relasi kelas untuk ditampilkan di respon
//         $siswa->load('kelas');

//         // 4. Respon sukses dengan status 201 Created
//         return response()->json([
//             'success' => true,
//             'message' => 'Siswa berhasil didaftarkan',
//             'data' => $siswa->only(['id', 'nama', 'nisn', 'kelas_id', 'jenis_kelamin', 'alamat', 'nomor_telepon']),
//         ], 201);
//     }

//     /**
//      * Melakukan otentikasi Siswa dan membuat API token (Sanctum).
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function login(Request $request)
//     {
//         // 1. Validasi input
//         $request->validate([
//             'nisn' => 'required|string',
//             'password' => 'required|string'
//         ]);

//         // 2. Cari Siswa berdasarkan NISN dan muat relasi kelas
//         $siswa = Siswa::with('kelas')->where('nisn', $request->nisn)->first();

//         // 3. Cek Siswa Ditemukan DAN Password Cocok.
//         // Jika salah satu gagal, berikan respon 401 Unauthorized dengan pesan generik.
//         if (!$siswa || !Hash::check($request->password, $siswa->password)) {
//             return response()->json([
//                 "success" => false,
//                 "message" => "NISN atau Password salah. Otentikasi gagal."
//             ], 401);
//         }

//         // 4. Generate token menggunakan Laravel Sanctum
//         // Pastikan model Siswa menggunakan trait HasApiTokens (Sanctum)
//         $token = $siswa->createToken('authToken')->plainTextToken;

//         // 5. Berhasil login → return JSON data Siswa dan Token
//         return response()->json([
//             'success' => true,
//             'message' => 'Login berhasil. Token dibuat.',
//             'data' => [
//                 'siswa' => [
//                     'id' => $siswa->id,
//                     'nama' => $siswa->nama,
//                     'nisn' => $siswa->nisn,
//                     'kelas' => $siswa->kelas->nama_kelas,
//                     'jenis_kelamin' => $siswa->jenis_kelamin,
//                     'alamat' => $siswa->alamat,
//                     'nomor_telepon' => $siswa->nomor_telepon,
//                     'foto' => $fotoUrl, // 🔥 INI WAJIB ADA
//                 ],
//                 'token' => $token,
//                 'token_type' => 'Bearer',
//             ]
//         ]);

//     }

//     /**
//      * Mengubah password Siswa.
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function changePassword(Request $request)
//     {
//         // 1. Validasi input
//         $request->validate([
//             'nisn' => 'required|string',
//             'old_password' => 'required|string',
//             'new_password' => 'required|string|min:8|different:old_password' // Menambah validasi agar password baru berbeda dari yang lama
//         ]);

//         // 2. Ambil data siswa berdasarkan NISN
//         $siswa = Siswa::where('nisn', $request->nisn)->first();

//         if (!$siswa) {
//             return response()->json([
//                 "success" => false,
//                 "message" => "Siswa tidak ditemukan"
//             ], 404);
//         }

//         // 3. Cek password lama
//         if (!Hash::check($request->old_password, $siswa->password)) {
//             return response()->json([
//                 "success" => false,
//                 "message" => "Password lama salah"
//             ], 400);
//         }

//         // 4. Update password baru menggunakan Hash::make()
//         $siswa->password = Hash::make($request->new_password);
//         $siswa->save();

//         return response()->json([
//             "success" => true,
//             "message" => "Password berhasil diperbarui"
//         ]);
//     }
//     public function updateEmail(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|email|unique:siswa,email',
//             'nisn' => 'required'
//         ]);

//         $siswa = Siswa::where('nisn', $request->nisn)->first();

//         if (!$siswa) {
//             return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
//         }

//         $siswa->update([
//             'email' => $request->email
//         ]);

//         return response()->json([
//             'message' => 'Email berhasil diperbarui',
//             'email' => $siswa->email
//         ]);
//     }



//     /**
//      * Contoh fungsi untuk mendapatkan detail siswa setelah otentikasi.
//      * Metode ini akan dilindungi oleh middleware 'auth:sanctum'.
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function user(Request $request)
//     {
//         // Siswa yang sedang login dapat diakses melalui $request->user()
//         $siswa = $request->user();
        
//         // Muat kelas dan sembunyikan password
//         $siswa->load('kelas');

//         return response()->json([
//             'success' => true,
//             'message' => 'Data Siswa terotentikasi',
//             'data' => $siswa->makeHidden(['password']),
//         ]);
//     }

//     /**
//      * Logout Siswa (menghapus token).
//      * Metode ini akan dilindungi oleh middleware 'auth:sanctum'.
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function logout(Request $request)
//     {
//         // Hapus token saat ini yang digunakan untuk request
//         $request->user()->currentAccessToken()->delete();

//         return response()->json([
//             'success' => true,
//             'message' => 'Logout berhasil. Token API dihapus.'
//         ]);
//     }

//     public function verifyAccount(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email',
//         'nomor_telepon' => 'required'
//     ]);

//     // Cari siswa berdasarkan email
//     $siswa = Siswa::where('email', $request->email)->first();

//     if (!$siswa) {
//         return response()->json([
//             "success" => false,
//             "message" => "Email tidak ditemukan"    
//         ], 404);
//     }

//     // Cocokkan nomor telepon
//     if ($siswa->nomor_telepon !== $request->nomor_telepon) {
//         return response()->json([
//             "success" => false,
//             "message" => "Nomor telepon tidak cocok"
//         ], 401);
//     }

//     // Jika cocok
//     return response()->json([
//         "success" => true,
//         "message" => "Verifikasi berhasil",
//         "data" => [
//             "id" => $siswa->id,
//             "nama" => $siswa->nama,
//             "nisn" => $siswa->nisn,
//             "nomor_telepon" => $siswa->nomor_telepon,
//         ]
//     ]);
// }

// }



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class SiswaAuthController extends Controller
{
    /**
     * REGISTER SISWA
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'nisn' => 'required|string|unique:siswa,nisn',
            'password' => 'required|string|min:8',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:15',
        ]);

        // Foto default
        $defaultFoto = "uploads/siswa/default.png";

        $siswa = Siswa::create([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'foto_profil' => $defaultFoto
        ]);

        $siswa->load('kelas');

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil didaftarkan',
            'data' => $siswa,
        ], 201);
    }

    /**
     * LOGIN SISWA
     */
    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
            'password' => 'required|string'
        ]);

        $siswa = Siswa::with('kelas')->where('nisn', $request->nisn)->first();

        if (!$siswa || !Hash::check($request->password, $siswa->password)) {
            return response()->json([
                'success' => false,
                'message' => 'NISN atau Password salah.'
            ], 401);
        }

        // Generate Foto URL
        $fotoUrl = $siswa->foto_profil
            ? asset('storage/' . $siswa->foto_profil)
            : asset('uploads/siswa/default.png');

        // Token Sanctum
        $token = $siswa->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'siswa' => [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'nisn' => $siswa->nisn,
                    'email' => $siswa->email,

                    'kelas_id' => $siswa->kelas_id,
                    'kelas' => $siswa->kelas->nama_kelas ?? null,

                    'tingkat' => $siswa->kelas->tingkat ?? null, // ✅ TAMBAHKAN INI

                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'alamat' => $siswa->alamat,
                    'nomor_telepon' => $siswa->nomor_telepon,
                    'foto' => $fotoUrl
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    /**
     * CHANGE PASSWORD
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|different:old_password'
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();

        if (!$siswa) {
            return response()->json([
                "success" => false,
                "message" => "Siswa tidak ditemukan"
            ], 404);
        }

        if (!Hash::check($request->old_password, $siswa->password)) {
            return response()->json([
                "success" => false,
                "message" => "Password lama salah"
            ], 400);
        }

        $siswa->password = Hash::make($request->new_password);
        $siswa->save();

        return response()->json([
            "success" => true,
            "message" => "Password berhasil diperbarui"
        ]);
    }

    /**
     * UPDATE EMAIL
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:siswa,email',
            'nisn' => 'required'
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->update(['email' => $request->email]);

        return response()->json([
            'message' => 'Email berhasil diperbarui',
            'email' => $siswa->email
        ]);
    }

    /**
     * DETAIL USER LOGIN
     */
    public function user(Request $request)
    {
        $siswa = $request->user();
        $siswa->load('kelas');

        $fotoUrl = $siswa->foto_profil
            ? asset('storage/' . $siswa->foto_profil)
            : asset('uploads/siswa/default.png');

        return response()->json([
            'success' => true,
            'message' => 'Data Siswa terotentikasi',
            'data' => [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nisn' => $siswa->nisn,
                'kelas' => $siswa->kelas->nama_kelas ?? null,
                'foto' => $fotoUrl
            ]
        ]);
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.'
        ]);
    }

    /**
     * VERIFIKASI EMAIL + TELEPON
     */
    public function verifyAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nomor_telepon' => 'required'
        ]);

        $siswa = Siswa::where('email', $request->email)->first();

        if (!$siswa) {
            return response()->json([
                "success" => false,
                "message" => "Email tidak ditemukan"
            ], 404);
        }

        if ($siswa->nomor_telepon !== $request->nomor_telepon) {
            return response()->json([
                "success" => false,
                "message" => "Nomor telepon salah"
            ], 401);
        }

        return response()->json([
            "success" => true,
            "message" => "Verifikasi berhasil",
            "data" => [
                "id" => $siswa->id,
                "nama" => $siswa->nama,
                "nisn" => $siswa->nisn,
                "nomor_telepon" => $siswa->nomor_telepon,
            ]
        ]);
    }
}
