<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class StudentDashboardController extends Controller
{
    public function showRegister()
    {
        $jurusans = Jurusan::all();
        
        return Inertia::render('Student/Register', [
            'jurusans' => $jurusans
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:calon_siswa,email',
            'password' => 'required|min:6|confirmed',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $siswa = CalonSiswa::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jurusan_id' => $request->jurusan_id,
            'status_pendaftaran' => 'draft',
        ]);

        $request->session()->put('user', [
            'id' => $siswa->id,
            'nama' => $siswa->nama,
            'email' => $siswa->email,
        ]);

        return redirect()->route('siswa.dashboard');
    }

    public function showLogin()
    {
        return Inertia::render('Student/Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $siswa = CalonSiswa::where('email', $request->email)->first();

        if (!$siswa || !Hash::check($request->password, $siswa->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        $request->session()->put('user', [
            'id' => $siswa->id,
            'nama' => $siswa->nama,
            'email' => $siswa->email,
        ]);

        return redirect()->route('siswa.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('siswa.login');
    }
}
