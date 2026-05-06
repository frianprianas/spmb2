<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminJurusanController extends Controller
{
    public function index()
    {
        $jurusanList = Jurusan::all();
        
        return Inertia::render('Admin/Jurusan/Index', [
            'jurusanList' => $jurusanList
        ]);
    }

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
        
        while (Jurusan::where('kode_jurusan', $kode_jurusan)->exists()) {
            $counter++;
            $kode_jurusan = $kode . $counter;
        }

        Jurusan::create([
            'kode_jurusan' => $kode_jurusan,
            'nama_jurusan' => $validated['nama_jurusan'],
            'deskripsi' => $validated['deskripsi'],
            'kuota' => $validated['kuota'],
            'is_active' => true
        ]);

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1'
        ]);

        $jurusan->update($validated);

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diupdate');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus');
    }
}
