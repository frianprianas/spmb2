<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormulirLengkap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FormulirLengkapController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $formulir = FormulirLengkap::where('calon_siswa_id', $request->user()->id)->first();

        if (!$formulir) {
            return response()->json(['success' => true, 'data' => null, 'message' => 'Formulir belum diisi.'], 200);
        }

        return response()->json(['success' => true, 'data' => $formulir]);
    }

    /**
     * Store a newly created or updated resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'kewarganegaraan' => 'required|string|max:255',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'no_hp_siswa' => 'required|string|max:20',
            'email_siswa' => 'required|email|max:255',
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:5',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'pendidikan_ayah' => 'required|string|max:255',
            'penghasilan_ayah' => 'nullable|numeric',
            'no_hp_ayah' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'pendidikan_ibu' => 'required|string|max:255',
            'penghasilan_ibu' => 'nullable|numeric',
            'no_hp_ibu' => 'required|string|max:20',
            'npsn_smp' => 'required|string|max:255',
            'tahun_lulus' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'scan_akta' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_ijazah' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->except(['foto', 'scan_akta', 'scan_ijazah']);
        $data['calon_siswa_id'] = $user->id;

        $formulir = FormulirLengkap::updateOrCreate(['calon_siswa_id' => $user->id], $data);

        // Handle file uploads
        if ($request->hasFile('foto')) {
            if ($formulir->foto) Storage::disk('public')->delete($formulir->foto);
            $path = $request->file('foto')->store('dokumen_formulir', 'public');
            $formulir->foto = $path;
        }
        if ($request->hasFile('scan_akta')) {
            if ($formulir->scan_akta) Storage::disk('public')->delete($formulir->scan_akta);
            $path = $request->file('scan_akta')->store('dokumen_formulir', 'public');
            $formulir->scan_akta = $path;
        }
        if ($request->hasFile('scan_ijazah')) {
            if ($formulir->scan_ijazah) Storage::disk('public')->delete($formulir->scan_ijazah);
            $path = $request->file('scan_ijazah')->store('dokumen_formulir', 'public');
            $formulir->scan_ijazah = $path;
        }
        $formulir->save();

        // Update status formulir di calon_siswa
        $user->status_formulir = 'sudah_isi';
        $user->save();

        return response()->json(['success' => true, 'message' => 'Formulir berhasil disimpan.', 'data' => $formulir]);
    }
}
