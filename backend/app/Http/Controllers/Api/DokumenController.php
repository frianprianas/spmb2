<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokumenController extends Controller
{
    public function uploadKK(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'errors' => $validator->errors()
            ], 422);
        }

        $calonSiswa = Auth::user();

        if ($request->hasFile('file_kk')) {
            // Hapus file lama jika ada
            if ($calonSiswa->file_kk && Storage::disk('public')->exists($calonSiswa->file_kk)) {
                Storage::disk('public')->delete($calonSiswa->file_kk);
            }

            // Simpan file baru
            $file = $request->file('file_kk');
            $path = $file->store('dokumen_kk', 'public');

            // Update database
            $calonSiswa->file_kk = $path;
            $calonSiswa->status_upload_kk = 'sudah_upload';
            $calonSiswa->save();

            return response()->json([
                'success' => true,
                'message' => 'File Kartu Keluarga berhasil diunggah.',
                'data' => [
                    'file_path' => Storage::url($path)
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan.'
        ], 400);
    }
}
