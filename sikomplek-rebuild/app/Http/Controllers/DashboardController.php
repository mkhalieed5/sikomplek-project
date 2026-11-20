<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Iuran;
use App\Models\Surat;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tenantId = $user->tenant_id;
        
        // Data default yang dikirim ke view
        $data = [
            'role' => $user->role,
        ];

        // -------------------------------------------------------------
        // 1. DOKUMEN & METRIK UNTUK ADMIN / SUPER ADMIN (PAK RT)
        // -------------------------------------------------------------
        if (in_array($user->role, ['super_admin', 'tenant_admin'])) {
            // Menghitung total warga di tenant/komplek yang sama
            $data['totalWarga'] = User::where('tenant_id', $tenantId)
                ->where('role', 'warga')
                ->count();

            // Total pengajuan surat yang butuh persetujuan
            $data['totalPendingSuratCount'] = Surat::where('tenant_id', $tenantId)
                ->where('status', 'pending')
                ->count();

            // List 5 pengajuan surat terbaru
            $data['pendingSurat'] = Surat::with('user')
                ->where('tenant_id', $tenantId)
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();
        }

        // -------------------------------------------------------------
        // 2. METRIK & DRAFT KE UANGAN UNTUK BENDAHARA
        // -------------------------------------------------------------
        if (in_array($user->role, ['super_admin', 'bendahara'])) {
            // Total penerimaan kas bulan berjalan yang sudah di-approve
            $data['kasBulanIni'] = Iuran::where('tenant_id', $tenantId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'approved')
                ->sum('nominal');

            // Menghitung berapa KK/Warga yang sudah bayar bulan ini
            $data['sudahBayarCount'] = Iuran::where('tenant_id', $tenantId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'approved')
                ->distinct('user_id')
                ->count('user_id');

            // Bukti iuran yang diupload warga & menunggu verifikasi bendahara
            $data['pendingIuran'] = Iuran::with('user')
                ->where('tenant_id', $tenantId)
                ->where('status', 'pending')
                ->latest()
                ->get();
        }

        // -------------------------------------------------------------
        // 3. INFORMASI KHUSUS UNTUK WARGA
        // -------------------------------------------------------------
        if ($user->role === 'warga') {
            // Cek status iuran milik warga login di bulan ini
            $data['iuranSayaBulanIni'] = Iuran::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->first();

            // Pengumuman terbaru dari RT
            $data['pengumumanTerbaru'] = Pengumuman::where('tenant_id', $tenantId)
                ->latest()
                ->first();
        }

        return view('dashboard', $data);
    }
}