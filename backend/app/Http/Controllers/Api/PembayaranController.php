<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function __construct()
    {
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;
    }

    public function createTransaction(Request $request)
    {
        $user = $request->user();

        // Buat nomor order unik
        $orderId = 'SPMB-' . $user->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => 150000, // Biaya pendaftaran
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email' => $user->email,
                'phone' => $user->no_hp,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Simpan snap token ke user
            $user->update(['snap_token_pembayaran' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function notificationHandler(Request $request)
    {
        // TODO: Implement notification handler
        // Disini Anda akan memproses notifikasi dari Midtrans setelah pembayaran selesai
        // Misalnya, update status_pembayaran di database
        return response()->json(['message' => 'ok']);
    }
}
