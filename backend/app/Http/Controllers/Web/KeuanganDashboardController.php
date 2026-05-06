<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KeuanganDashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_pembayaran' => Pembayaran::count(),
            'sudah_verifikasi' => Pembayaran::where('status_verifikasi', 'verified')->count(),
            'menunggu_verifikasi' => Pembayaran::where('status_verifikasi', 'pending')->count(),
        ];

        return Inertia::render('Keuangan/Dashboard', [
            'stats' => $stats
        ]);
    }

    public function verifikasiIndex()
    {
        $pembayarans = Pembayaran::with('calonSiswa')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Keuangan/Verifikasi', [
            'pembayarans' => $pembayarans
        ]);
    }

    public function verifikasiUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status_verifikasi = $request->status;
        $pembayaran->verified_by = $request->session()->get('keuangan.id');
        $pembayaran->verified_at = now();
        $pembayaran->save();

        // Update status pembayaran calon siswa
        if ($request->status === 'verified') {
            $pembayaran->calonSiswa->update([
                'status_pembayaran' => 'lunas'
            ]);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate');
    }
}
