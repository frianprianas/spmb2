<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticateAdmin
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

        // Cek apakah tokenable_type adalah Admin
        if ($accessToken->tokenable_type !== 'App\\Models\\Admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Bukan token admin'
            ], 401);
        }

        // Set authenticated admin
        $admin = $accessToken->tokenable;
        $request->setUserResolver(function () use ($admin) {
            return $admin;
        });

        return $next($request);
    }
}
