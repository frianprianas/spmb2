<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Pembayaran;
use App\Models\FormulirLengkap;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Get dashboard statistics
    public function getDashboardStats()
    {
        $totalCalonSiswa = CalonSiswa::count();
        $pendaftarBaru = CalonSiswa::whereDate('created_at', today())->count();
        $sudahBayar = CalonSiswa::where('status_pembayaran', 'sudah_bayar')->count();
        $sudahLengkap = CalonSiswa::where('status_formulir', 'lengkap')->count();
        $menungguVerifikasi = CalonSiswa::where('status_pembayaran', 'verifikasi')->count();
        
        $perJurusan = DB::table('calon_siswa')
            ->join('jurusan', 'calon_siswa.jurusan_id', '=', 'jurusan.id')
            ->select('jurusan.nama_jurusan', DB::raw('count(*) as total'))
            ->groupBy('jurusan.nama_jurusan')
            ->get();

        return response()->json([
            'total_calon_siswa' => $totalCalonSiswa,
            'pendaftar_baru' => $pendaftarBaru,
            'sudah_bayar' => $sudahBayar,
            'sudah_lengkap' => $sudahLengkap,
            'menunggu_verifikasi' => $menungguVerifikasi,
            'per_jurusan' => $perJurusan
        ]);
    }

    // Get all calon siswa with pagination and filters
    public function getCalonSiswa(Request $request)
    {
        $query = CalonSiswa::with(['jurusan', 'pembayaran', 'formulirLengkap'])
            ->orderBy('created_at', 'desc');

        // Filter by jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('jurusan_id', $request->jurusan);
        }

        // Filter by status pembayaran (enum values)
        if ($request->has('status_pembayaran') && $request->status_pembayaran != '') {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // Filter by status formulir (enum values)
        if ($request->has('status_formulir') && $request->status_formulir != '') {
            $query->where('status_formulir', $request->status_formulir);
        }

        // Filter by status pendaftaran
        if ($request->has('status_pendaftaran') && $request->status_pendaftaran != '') {
            $query->where('status_pendaftaran', $request->status_pendaftaran);
        }

        // Search by name or email
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

    // Verifikasi pembayaran
    public function verifikasiPembayaran(Request $request, $id)
    {
        $pembayaran = Pembayaran::where('id_calon_siswa', $id)->firstOrFail();
        
        $pembayaran->update([
            'status' => $request->status, // 'verified' atau 'rejected'
            'catatan_admin' => $request->catatan
        ]);

        if ($request->status === 'verified') {
            CalonSiswa::where('id', $id)->update([
                'status_pembayaran' => 'sudah_bayar'
            ]);
        } else if ($request->status === 'rejected') {
            CalonSiswa::where('id', $id)->update([
                'status_pembayaran' => 'belum_bayar'
            ]);
        }

        return response()->json([
            'message' => 'Pembayaran berhasil diverifikasi',
            'pembayaran' => $pembayaran
        ]);
    }

    // Get pembayaran yang belum diverifikasi
    public function getPembayaranPending()
    {
        $pembayaran = Pembayaran::with(['calonSiswa.jurusan'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($pembayaran);
    }

    // Delete calon siswa
    public function deleteCalonSiswa($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        
        // Delete related records
        Pembayaran::where('id_calon_siswa', $id)->delete();
        FormulirLengkap::where('id_calon_siswa', $id)->delete();
        
        $calonSiswa->delete();

        return response()->json([
            'message' => 'Calon siswa berhasil dihapus'
        ]);
    }
}
