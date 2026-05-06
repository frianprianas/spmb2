<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_calon_siswa' => CalonSiswa::count(),
            'pendaftar_baru' => CalonSiswa::whereDate('created_at', today())->count(),
            'sudah_bayar' => CalonSiswa::where('status_pembayaran', 'sudah_bayar')->count(),
            'sudah_lengkap' => CalonSiswa::where('status_formulir', 'lengkap')->count(),
            'menunggu_verifikasi' => CalonSiswa::where('status_pembayaran', 'verifikasi')->count(),
            'per_jurusan' => Jurusan::leftJoin('calon_siswa', 'jurusan.id', '=', 'calon_siswa.jurusan_id')
                ->select('jurusan.nama_jurusan', DB::raw('COUNT(calon_siswa.id) as total'))
                ->groupBy('jurusan.id', 'jurusan.nama_jurusan')
                ->get()
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }

    public function calonSiswaIndex()
    {
        $calonSiswa = CalonSiswa::with('jurusan')->paginate(10);
        
        return Inertia::render('Admin/CalonSiswa/Index', [
            'calonSiswa' => $calonSiswa
        ]);
    }
}
