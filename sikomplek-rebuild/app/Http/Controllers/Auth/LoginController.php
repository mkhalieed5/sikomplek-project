<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses autentikasi login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Fitur Cerdas: Cek apakah input berupa Email atau NIK
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        // Percobaan Login
        if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Direct route / pesan selamat datang berdasarkan Role
            $user = Auth::user();
            if ($user->role === 'super_admin') {
                return redirect()->intended('/home')->with('success', 'Selamat Datang Super Admin!');
            } elseif ($user->role === 'tenant_admin') {
                return redirect()->intended('/home')->with('success', 'Selamat Datang Pak RT!');
            }

            return redirect()->intended('/home');
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Email/NIK atau Kata Sandi yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}