<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\KartuKeluargaCrudController;
use App\Http\Controllers\KategoriIuranCrudController;
use App\Http\Controllers\PembayaranIuranCrudController;
use App\Http\Controllers\WargaCrudController;
use App\Models\Iuran;
use App\Models\KartuKeluarga;
use App\Models\PembayaranIuran;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('landing');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        $user = auth()->user();
        $tenant = $user->tenant;
        $tenantId = $user->tenant_id;

        $view = match ($user->role) {
            'super_admin' => 'home.super-admin',
            'tenant_admin' => 'home.admin',
            default => 'home.warga',
        };

        return view($view, [
            'user' => $user,
            'tenant' => $tenant,
            'totalTenant' => $user->role === 'super_admin' ? \App\Models\Tenant::count() : null,
            'totalKk' => $user->role === 'super_admin'
                ? KartuKeluarga::count()
                : ($tenantId ? KartuKeluarga::where('tenant_id', $tenantId)->count() : 0),
            'totalWarga' => $user->role === 'super_admin'
                ? User::where('role', 'warga')->count()
                : ($tenantId ? User::where('tenant_id', $tenantId)->where('role', 'warga')->count() : 0),
            'pemasukanBulanIni' => $tenantId
                ? Iuran::where('tenant_id', $tenantId)
                    ->where('status', 'approved')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('nominal')
                : 0,
            'belumBayar' => $tenantId
                ? KartuKeluarga::where('tenant_id', $tenantId)->count() - Iuran::where('tenant_id', $tenantId)
                    ->where('status', 'approved')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->distinct('user_id')
                    ->count('user_id')
                : 0,
            'recentPayments' => $tenantId
                ? PembayaranIuran::with(['kartuKeluarga', 'kategoriIuran'])
                    ->where('tenant_id', $tenantId)
                    ->latest('tanggal_bayar')
                    ->take(5)
                    ->get()
                : collect(),
            'recentTenants' => $user->role === 'super_admin'
                ? \App\Models\Tenant::latest()->take(5)->get()
                : collect(),
        ]);
    })->name('dashboard');

});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/register-rt', fn () => view('auth.register-rt'))->name('register-rt');
    Route::post('/register-rt', [\App\Http\Controllers\Api\AuthController::class, 'registerTenant'])->middleware('throttle:5,1');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/register-rt/success', function () {
        abort_unless(session()->has('tenant_code'), 404);

        return view('auth.register-rt-success');
    })->name('register-rt.success');
});

Route::middleware('auth')->group(function () {
    Route::get('/kartu-keluarga', [KartuKeluargaCrudController::class, 'index'])->name('kartu-keluarga');
    Route::get('/kartu-keluarga/create', [KartuKeluargaCrudController::class, 'create'])->name('kartu-keluarga.create');
    Route::post('/kartu-keluarga', [KartuKeluargaCrudController::class, 'store'])->name('kartu-keluarga.store');
    Route::get('/kartu-keluarga/{id}/edit', [KartuKeluargaCrudController::class, 'edit'])->name('kartu-keluarga.edit');
    Route::put('/kartu-keluarga/{id}', [KartuKeluargaCrudController::class, 'update'])->name('kartu-keluarga.update');
    Route::delete('/kartu-keluarga/{id}', [KartuKeluargaCrudController::class, 'destroy'])->name('kartu-keluarga.destroy');

    Route::get('/warga', [WargaCrudController::class, 'index'])->name('warga');
    Route::get('/warga/create', [WargaCrudController::class, 'create'])->name('warga.create');
    Route::post('/warga', [WargaCrudController::class, 'store'])->name('warga.store');
    Route::get('/warga/{id}/edit', [WargaCrudController::class, 'edit'])->name('warga.edit');
    Route::put('/warga/{id}', [WargaCrudController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{id}', [WargaCrudController::class, 'destroy'])->name('warga.destroy');
});

Route::middleware(['auth', 'can:manage-iuran'])->group(function () {
    Route::get('/iuran', [KategoriIuranCrudController::class, 'index'])->name('iuran');
    Route::get('/kategori-iuran', [KategoriIuranCrudController::class, 'index'])->name('kategori-iuran');
    Route::get('/kategori-iuran/create', [KategoriIuranCrudController::class, 'create'])->name('kategori-iuran.create');
    Route::post('/kategori-iuran', [KategoriIuranCrudController::class, 'store'])->name('kategori-iuran.store');
    Route::get('/kategori-iuran/{id}/edit', [KategoriIuranCrudController::class, 'edit'])->name('kategori-iuran.edit');
    Route::put('/kategori-iuran/{id}', [KategoriIuranCrudController::class, 'update'])->name('kategori-iuran.update');
    Route::delete('/kategori-iuran/{id}', [KategoriIuranCrudController::class, 'destroy'])->name('kategori-iuran.destroy');

    Route::get('/pembayaran-iuran', [PembayaranIuranCrudController::class, 'index'])->name('pembayaran-iuran');
    Route::get('/pembayaran-iuran/create', [PembayaranIuranCrudController::class, 'create'])->name('pembayaran-iuran.create');
    Route::post('/pembayaran-iuran', [PembayaranIuranCrudController::class, 'store'])->name('pembayaran-iuran.store');
    Route::get('/pembayaran-iuran/{id}/edit', [PembayaranIuranCrudController::class, 'edit'])->name('pembayaran-iuran.edit');
    Route::put('/pembayaran-iuran/{id}', [PembayaranIuranCrudController::class, 'update'])->name('pembayaran-iuran.update');
    Route::delete('/pembayaran-iuran/{id}', [PembayaranIuranCrudController::class, 'destroy'])->name('pembayaran-iuran.destroy');
});
