<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->merge([
            'tenant_code' => strtoupper(trim((string) $request->input('tenant_code'))),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'tenant_code' => 'required|string|exists:tenants,code',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'tenant_code.exists' => 'Kode Komplek/RT tidak ditemukan. Silakan hubungi Pak RT Anda.',
        ]);

        $tenant = Tenant::where('code', $request->tenant_code)->firstOrFail();

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'warga',
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/home')->with('success', 'Akun berhasil dibuat dan Anda telah masuk!');
    }
}
