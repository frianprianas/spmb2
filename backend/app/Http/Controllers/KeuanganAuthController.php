<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KeuanganAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $keuangan = Keuangan::where('email', $request->email)->first();

        if (!$keuangan || !Hash::check($request->password, $keuangan->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $token = $keuangan->createToken('keuangan-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'keuangan' => $keuangan,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    public function getKeuangan(Request $request)
    {
        return response()->json($request->user());
    }
}
