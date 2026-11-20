<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function registerTenant(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nama_komplek' => ['required', 'string', 'max:255'],
            'alamat_jalan' => ['nullable', 'string', 'max:500', 'required_without:alamat'],
            'alamat' => ['nullable', 'string', 'max:1000'],
            'province_id' => ['nullable', 'string', 'required_with:regency_id,district_id,village_id', 'regex:/^\d{2}$/'],
            'regency_id' => ['nullable', 'string', 'required_with:province_id,district_id,village_id', 'regex:/^\d{4}$/'],
            'district_id' => ['nullable', 'string', 'required_with:province_id,regency_id,village_id', 'regex:/^\d{7}$/'],
            'village_id' => ['nullable', 'string', 'required_with:province_id,regency_id,district_id', 'regex:/^\d{10}$/'],
            'kode_pos' => ['nullable', 'string', 'regex:/^\d{5}$/'],
        ]);

        $code = $this->generateTenantCode();

        [$tenant, $user] = DB::transaction(function () use ($validated, $code) {
            $streetAddress = $validated['alamat_jalan'] ?? $validated['alamat'] ?? null;

            $tenant = Tenant::create([
                'name' => $validated['nama_komplek'],
                'code' => $code,
                'address' => $streetAddress,
                'alamat_jalan' => $streetAddress,
                'province_id' => $validated['province_id'] ?? null,
                'regency_id' => $validated['regency_id'] ?? null,
                'district_id' => $validated['district_id'] ?? null,
                'village_id' => $validated['village_id'] ?? null,
                'kode_pos' => $validated['kode_pos'] ?? null,
                'status' => 'active',
            ]);

            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => 'tenant_admin',
                'password' => Hash::make($validated['password']),
            ]);

            return [$tenant, $user];
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Komplek berhasil didaftarkan.',
                'tenant' => $tenant,
                'tenant_code' => $tenant->code,
                'user' => $user,
                'token' => $user->createToken('tenant-admin-token')->plainTextToken,
            ], 201);
        }

        Auth::login($user);

        return redirect()->route('register-rt.success')
            ->with('success', 'Komplek berhasil didaftarkan.')
            ->with('tenant_code', $tenant->code);
    }

    private function generateTenantCode(): string
    {
        do {
            $code = 'RT-'.Str::upper(Str::random(6));
        } while (Tenant::where('code', $code)->exists());

        return $code;
    }

    public function register(Request $request)
    {
        $request->merge([
            'tenant_code' => strtoupper(trim((string) $request->input('tenant_code'))),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'tenant_code' => [
                'required',
                'string',
                'max:255',
                Rule::exists('tenants', 'code'),
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'tenant_code.exists' => 'Kode Komplek/RT tidak ditemukan. Silakan hubungi Pak RT Anda.',
        ]);

        $tenant = Tenant::where('code', $validated['tenant_code'])->first();

        if (! $tenant) {
            return response()->json([
                'message' => 'Kode Komplek/RT tidak ditemukan. Silakan hubungi Pak RT Anda.',
                'errors' => [
                    'tenant_code' => ['Kode Komplek/RT tidak ditemukan. Silakan hubungi Pak RT Anda.'],
                ],
            ], 422);
        }

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => 'warga',
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'user' => $user->load('tenant'),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Generate Token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil',
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Ambil data profil user yang sedang login
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()->load('tenant'),
        ]);
    }

    /**
     * Logout (hapus token yang sedang digunakan)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }
}
