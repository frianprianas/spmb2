<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    // Dashboard statistics
    public function getDashboardStats()
    {
        $totalCalonSiswa = CalonSiswa::count();
        $belumBayar = CalonSiswa::where('status_pembayaran', 'belum_bayar')->count();
        $menungguVerifikasi = CalonSiswa::where('status_pembayaran', 'verifikasi')->count();
        $sudahBayar = CalonSiswa::where('status_pembayaran', 'sudah_bayar')->count();
        
        $perJurusan = DB::table('calon_siswa')
            ->join('jurusan', 'calon_siswa.jurusan_id', '=', 'jurusan.id')
            ->select('jurusan.nama_jurusan', DB::raw('count(*) as total'))
            ->where('calon_siswa.status_pembayaran', 'sudah_bayar')
            ->groupBy('jurusan.nama_jurusan')
            ->get();

        return response()->json([
            'total_calon_siswa' => $totalCalonSiswa,
            'belum_bayar' => $belumBayar,
            'menunggu_verifikasi' => $menungguVerifikasi,
            'sudah_bayar' => $sudahBayar,
            'per_jurusan' => $perJurusan
        ]);
    }

    // Get calon siswa with pagination and filters (fokus pembayaran)
    public function getCalonSiswa(Request $request)
    {
        $query = CalonSiswa::with(['jurusan', 'pembayaran'])
            ->orderBy('created_at', 'desc');

        // Filter by jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('jurusan_id', $request->jurusan);
        }

        // Filter by status pembayaran
        if ($request->has('status_pembayaran') && $request->status_pembayaran != '') {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // Search by name, email, or no_pendaftaran
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhere('no_pendaftaran', 'ILIKE', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $calonSiswa = $query->paginate($perPage);

        return response()->json($calonSiswa);
    }

    // Get detail calon siswa
    public function getDetailCalonSiswa($id)
    {
        $calonSiswa = CalonSiswa::with(['jurusan', 'pembayaran', 'formulirLengkap'])
            ->findOrFail($id);

        return response()->json($calonSiswa);
    }

    // Verifikasi pembayaran - HANYA KEUANGAN
    public function verifikasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:sudah_bayar,belum_bayar',
            'catatan' => 'nullable|string'
        ]);

        $calonSiswa = CalonSiswa::findOrFail($id);
        
        // Update status pembayaran
        $calonSiswa->update([
            'status_pembayaran' => $request->status
        ]);

        // Update pembayaran jika ada
        $pembayaran = Pembayaran::where('calon_siswa_id', $id)->first();
        if ($pembayaran) {
            $pembayaran->update([
                'status' => $request->status === 'sudah_bayar' ? 'verified' : 'rejected',
                'catatan_admin' => $request->catatan
            ]);
        }

        return response()->json([
            'message' => 'Status pembayaran berhasil diupdate',
            'calon_siswa' => $calonSiswa
        ]);
    }

    // Tolak pembayaran
    public function tolakPembayaran(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        $calonSiswa = CalonSiswa::findOrFail($id);
        
        $calonSiswa->update([
            'status_pembayaran' => 'belum_bayar'
        ]);

        $pembayaran = Pembayaran::where('calon_siswa_id', $id)->first();
        if ($pembayaran) {
            $pembayaran->update([
                'status' => 'rejected',
                'catatan_admin' => $request->catatan
            ]);
        }

        return response()->json([
            'message' => 'Pembayaran ditolak',
            'calon_siswa' => $calonSiswa
        ]);
    }
}
