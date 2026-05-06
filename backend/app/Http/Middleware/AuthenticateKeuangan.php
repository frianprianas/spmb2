<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Keuangan;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticateKeuangan
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Token tidak ditemukan'
            ], 401);
        }

        // Cari token di database
        $accessToken = PersonalAccessToken::findToken($token);
        
        if (!$accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Token tidak valid'
            ], 401);
        }

        // Cek apakah tokenable_type adalah Keuangan
        if ($accessToken->tokenable_type !== 'App\\Models\\Keuangan') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Bukan token keuangan'
            ], 401);
        }

        // Set authenticated keuangan
        $keuangan = $accessToken->tokenable;
        $request->setUserResolver(function () use ($keuangan) {
            return $keuangan;
        });

        return $next($request);
    }
}
