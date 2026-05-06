<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormulirLengkap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FormulirController extends Controller
{
    /**
     * Get formulir data for authenticated user
     */
    public function show(Request $request)
    {
        $formulir = $request->user()->formulirLengkap;

        if (!$formulir) {
            return response()->json([
                'success' => false,
                'message' => 'Formulir belum diisi'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $formulir
        ]);
    }

    /**
     * Store or update formulir lengkap
     */
    public function store(Request $request)
    {
        // Check if payment is verified
        if ($request->user()->status_pembayaran !== 'sudah_bayar') {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran belum diverifikasi. Silakan upload bukti pembayaran terlebih dahulu.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16',
            'nisn' => 'nullable|string|size:10',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'no_hp_siswa' => 'required|string|max:20',
            'email_siswa' => 'required|email|max:100',
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'kelurahan' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'kota' => 'required|string|max:50',
            'provinsi' => 'required|string|max:50',
            'kode_pos' => 'required|string|max:10',
            'nama_ayah' => 'required|string|max:100',
            'pekerjaan_ayah' => 'required|string|max:50',
            'pendidikan_ayah' => 'required|string|max:30',
            'no_hp_ayah' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:100',
            'pekerjaan_ibu' => 'required|string|max:50',
            'pendidikan_ibu' => 'required|string|max:30',
            'no_hp_ibu' => 'required|string|max:20',
            'tahun_lulus' => 'required|integer|min:2000|max:' . date('Y'),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'scan_kk' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_akta' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_ijazah' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except(['foto', 'scan_kk', 'scan_akta', 'scan_ijazah']);
        $data['calon_siswa_id'] = $request->user()->id;

        // Handle file uploads
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = 'foto_' . time() . '_' . $file->getClientOriginalName();
            $data['foto'] = $file->storeAs('formulir/foto', $fileName, 'public');
        }

        if ($request->hasFile('scan_kk')) {
            $file = $request->file('scan_kk');
            $fileName = 'kk_' . time() . '_' . $file->getClientOriginalName();
            $data['scan_kk'] = $file->storeAs('formulir/kk', $fileName, 'public');
        }

        if ($request->hasFile('scan_akta')) {
            $file = $request->file('scan_akta');
            $fileName = 'akta_' . time() . '_' . $file->getClientOriginalName();
            $data['scan_akta'] = $file->storeAs('formulir/akta', $fileName, 'public');
        }

        if ($request->hasFile('scan_ijazah')) {
            $file = $request->file('scan_ijazah');
            $fileName = 'ijazah_' . time() . '_' . $file->getClientOriginalName();
            $data['scan_ijazah'] = $file->storeAs('formulir/ijazah', $fileName, 'public');
        }

        // Check if formulir already exists
        $formulir = $request->user()->formulirLengkap;

        if ($formulir) {
            // Update existing formulir
            $formulir->update($data);
            $message = 'Formulir berhasil diperbarui!';
        } else {
            // Create new formulir
            $formulir = FormulirLengkap::create($data);
            $message = 'Formulir berhasil disimpan!';
            
            // Update status formulir calon siswa
            $request->user()->update([
                'status_formulir' => 'lengkap'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $formulir
        ], $formulir->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Update formulir lengkap
     */
    public function update(Request $request)
    {
        return $this->store($request);
    }
}
