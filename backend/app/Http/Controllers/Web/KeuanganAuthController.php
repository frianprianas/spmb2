<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class KeuanganAuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Keuangan/Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $keuangan = Keuangan::where('email', $request->email)->first();

        if (!$keuangan || !Hash::check($request->password, $keuangan->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        $request->session()->put('keuangan', [
            'id' => $keuangan->id,
            'nama' => $keuangan->nama,
            'email' => $keuangan->email,
        ]);

        return redirect()->route('keuangan.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('keuangan');
        return redirect()->route('keuangan.login');
    }
}
