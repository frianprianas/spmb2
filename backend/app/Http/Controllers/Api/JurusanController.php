<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of active jurusan
     */
    public function index()
    {
        $jurusan = Jurusan::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $jurusan
        ]);
    }

    /**
     * Display the specified jurusan
     */
    public function show($id)
    {
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jurusan
        ]);
    }

    /**
     * Store a newly created jurusan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1'
        ]);

        // Generate kode_jurusan otomatis
        $kode = strtoupper(substr($validated['nama_jurusan'], 0, 3));
        $counter = 1;
        $kode_jurusan = $kode . $counter;
        
        // Cek apakah kode sudah ada, jika ada tambah counter
        while (Jurusan::where('kode_jurusan', $kode_jurusan)->exists()) {
            $counter++;
            $kode_jurusan = $kode . $counter;
        }

        $jurusan = Jurusan::create([
            'kode_jurusan' => $kode_jurusan,
            'nama_jurusan' => $validated['nama_jurusan'],
            'deskripsi' => $validated['deskripsi'],
            'kuota' => $validated['kuota'],
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil ditambahkan',
            'data' => $jurusan
        ], 201);
    }

    /**
     * Update the specified jurusan
     */
    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1'
        ]);

        $jurusan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil diupdate',
            'data' => $jurusan
        ]);
    }

    /**
     * Remove the specified jurusan
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan tidak ditemukan'
            ], 404);
        }

        // Soft delete - set is_active to false
        $jurusan->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil dihapus'
        ]);
    }
}
