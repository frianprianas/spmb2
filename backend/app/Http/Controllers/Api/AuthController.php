<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalonSiswa;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Models\VerificationToken;
use Illuminate\Support\Facades\Http;
use App\Services\FonnteService;

class AuthController extends Controller
{
    public function getJurusan()
    {
        $jurusans = Jurusan::all();
        return response()->json([
            'success' => true,
            'data' => $jurusans
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|size:10|unique:calon_siswa',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'asal_smp' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
            'email' => 'required|string|email|max:255|unique:calon_siswa',
            'no_hp' => 'required|string|max:15|unique:calon_siswa',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $no_pendaftaran = 'BN666-' . date('Y') . '-' . str_pad(CalonSiswa::count() + 1, 4, '0', STR_PAD_LEFT);

        $calonSiswa = CalonSiswa::create([
            'no_pendaftaran' => $no_pendaftaran,
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'asal_smp' => $request->asal_smp,
            'jurusan_id' => $request->jurusan_id,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'status_pembayaran' => 'belum_bayar',
            'status_formulir' => 'belum_isi',
            'status_pendaftaran' => 'pending',
            'is_verified' => false,
        ]);

        // Generate verification token
        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        VerificationToken::create([
            'calon_siswa_id' => $calonSiswa->id,
            'token' => $token,
            'expires_at' => now()->addMinutes(15),
        ]);

        // Send verification code via WhatsApp using Fonnte
        try {
            $fonnteService = new FonnteService();
            $response = $fonnteService->sendVerificationToken($request->no_hp, $token, $request->nama);
            
            if (isset($response['status']) && $response['status'] === 'error') {
                \Log::error('Failed to send WhatsApp verification', ['response' => $response]);
            } else {
                \Log::info('WhatsApp verification sent successfully', ['response' => $response]);
            }
        } catch (\Exception $e) {
            \Log::error('Exception when sending WhatsApp message', ['error' => $e->getMessage()]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. Silakan cek WhatsApp Anda untuk kode verifikasi.',
            'data' => [
                'calon_siswa_id' => $calonSiswa->id
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $calonSiswa = CalonSiswa::where('email', $request->email)->first();

        if (!$calonSiswa || !Hash::check($request->password, $calonSiswa->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Check if user is verified
        if (!$calonSiswa->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda belum diverifikasi. Silakan verifikasi terlebih dahulu.',
                'needs_verification' => true,
                'calon_siswa_id' => $calonSiswa->id
            ], 403);
        }

        $token = $calonSiswa->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user' => $calonSiswa
            ]
        ]);
    }


    public function verify(Request $request)
    {
        $request->validate([
            'calon_siswa_id' => 'required|exists:calon_siswa,id',
            'token' => 'required|string|digits:6',
        ]);

        $verificationToken = VerificationToken::where('calon_siswa_id', $request->calon_siswa_id)
            ->where('token', $request->token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verificationToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token verifikasi tidak valid atau sudah kedaluwarsa.'
            ], 400);
        }

        $calonSiswa = CalonSiswa::find($request->calon_siswa_id);
        $calonSiswa->is_verified = true;
        $calonSiswa->save();

        // Hapus token setelah berhasil verifikasi
        $verificationToken->delete();

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi berhasil! Silakan login dengan email dan password Anda.',
            'data' => [
                'email' => $calonSiswa->email
            ]
        ]);
    }

    public function resendVerification(Request $request)
    {
        $request->validate([
            'calon_siswa_id' => 'required|exists:calon_siswa,id',
        ]);

        $calonSiswa = CalonSiswa::find($request->calon_siswa_id);

        if ($calonSiswa->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini sudah diverifikasi.'
            ], 400);
        }

        // Hapus token lama jika ada
        VerificationToken::where('calon_siswa_id', $calonSiswa->id)->delete();

        // Buat token baru
        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        VerificationToken::create([
            'calon_siswa_id' => $calonSiswa->id,
            'token' => $token,
            'expires_at' => now()->addMinutes(15),
        ]);

        // Kirim ulang kode verifikasi menggunakan Fonnte
        try {
            $fonnteService = new FonnteService();
            $response = $fonnteService->sendVerificationToken($calonSiswa->no_hp, $token, $calonSiswa->nama);
            
            if (isset($response['status']) && $response['status'] === 'error') {
                \Log::error('Failed to resend WhatsApp verification', ['response' => $response]);
                return response()->json(['success' => false, 'message' => 'Gagal mengirim ulang kode verifikasi.'], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Exception when resending WhatsApp message', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Gagal mengirim ulang kode verifikasi.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode verifikasi baru telah dikirimkan ke WhatsApp Anda.'
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    public function getMe(Request $request)
    {
        $user = $request->user()->load('jurusan');
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function uploadKK(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        if ($request->hasFile('file_kk')) {
            $file = $request->file('file_kk');
            $path = $file->store('public/kartu_keluarga');
            $user->file_kk = $path;
            $user->status_upload_kk = 'sudah_upload';
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Upload Kartu Keluarga berhasil.',
                'data' => $user,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan.',
        ], 400);
    }
}
