@extends('layouts.app')

@section('content')
<div class="space-y-8">

    {{-- ================================================================= --}}
    {{-- 1. DASHBOARD WARGA                                                --}}
    {{-- ================================================================= --}}
    @if(auth()->user()->role === 'warga')
        <!-- Hero Banner Warga -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-800 p-8 text-white shadow-lg">
            <div class="relative z-10 max-w-2xl space-y-3">
                <span class="inline-block rounded-full bg-emerald-500/30 px-3 py-1 text-xs font-semibold tracking-wide text-emerald-100 backdrop-blur-md">
                    Portal Layanan Warga
                </span>
                <h1 class="text-3xl font-extrabold sm:text-4xl">
                    Selamat Datang, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-emerald-100 text-sm sm:text-base leading-relaxed">
                    Pantau status iuran bulanan, pengajuan surat keterangan, dan pengumuman terbaru dari pengurus komplek di satu halaman.
                </p>
                <!-- Quick Actions -->
                <div class="pt-4 flex flex-wrap gap-3">
                    <a href="/iuran/create" class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-emerald-800 shadow hover:bg-emerald-50 transition">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Bayar Iuran
                    </a>
                    <a href="/surat/create" class="inline-flex items-center gap-2 rounded-xl bg-emerald-700/60 border border-emerald-400/40 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700 transition backdrop-blur-sm">
                        <i class="fa-solid fa-paper-plane"></i> Ajukan Surat
                    </a>
                </div>
            </div>
            <div class="absolute -bottom-10 -right-10 opacity-20 pointer-events-none">
                <i class="fa-solid fa-house-chimney text-[220px]"></i>
            </div>
        </div>

        <!-- Grid Status & Informasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Status Iuran -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-800">Status Iuran Kebersihan & Kas</h3>
                    <span class="text-xs font-medium text-gray-400">{{ now()->format('F Y') }}</span>
                </div>
                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Bulan Ini</p>
                        @if(isset($iuranSayaBulanIni) && $iuranSayaBulanIni->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                <i class="fa-solid fa-circle-check"></i> LUNAS
                            </span>
                        @elseif(isset($iuranSayaBulanIni) && $iuranSayaBulanIni->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                <i class="fa-solid fa-clock"></i> MENUNGGU VERIFIKASI
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                <i class="fa-solid fa-circle-xmark"></i> BELUM DIBAYAR
                            </span>
                        @endif
                    </div>
                    @if(!isset($iuranSayaBulanIni) || $iuranSayaBulanIni->status === 'rejected')
                        <a href="/iuran/create" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 underline">
                            Upload Bukti Sekarang &rarr;
                        </a>
                    @endif
                </div>
            </div>

            <!-- Card Pengumuman Terbaru -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-800">Pengumuman Terkini</h3>
                    <i class="fa-solid fa-bullhorn text-amber-500"></i>
                </div>
                @if(isset($pengumumanTerbaru) && $pengumumanTerbaru)
                    <div class="space-y-2">
                        <h4 class="font-bold text-gray-900">{{ $pengumumanTerbaru->judul }}</h4>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $pengumumanTerbaru->isi }}</p>
                        <p class="text-xs text-gray-400 pt-1">{{ $pengumumanTerbaru->created_at->diffForHumans() }}</p>
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">Belum ada pengumuman baru dari pengurus RT.</p>
                @endif
            </div>
        </div>

    {{-- ================================================================= --}}
    {{-- 2. DASHBOARD BENDAHARA                                            --}}
    {{-- ================================================================= --}}
    @elseif(auth()->user()->role === 'bendahara')
        <!-- Hero Banner Bendahara -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 to-indigo-950 p-8 text-white shadow-lg">
            <div class="relative z-10 max-w-2xl space-y-3">
                <span class="inline-block rounded-full bg-indigo-500/30 px-3 py-1 text-xs font-semibold text-indigo-200 border border-indigo-400/30">
                    Panel Modul Keuangan
                </span>
                <h1 class="text-3xl font-extrabold sm:text-4xl">
                    Manajemen Kas Komplek
                </h1>
                <p class="text-indigo-200 text-sm sm:text-base">
                    Kelola arus iuran warga, verifikasi pembayar transfer, dan alokasi kas bulanan secara transparan.
                </p>
            </div>
        </div>

        <!-- Metrics Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Kas Masuk (Bulan Ini)</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">
                        Rp {{ number_format($kasBulanIni ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl"><i class="fa-solid fa-wallet text-2xl"></i></div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Warga Sudah Bayar</p>
                    <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $sudahBayarCount ?? 0 }} KK</h3>
                </div>
                <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl"><i class="fa-solid fa-users text-2xl"></i></div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menunggu Verifikasi</p>
                    <h3 class="text-2xl font-black text-amber-600 mt-1">{{ isset($pendingIuran) ? $pendingIuran->count() : 0 }} Data</h3>
                </div>
                <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl"><i class="fa-solid fa-clock-rotate-left text-2xl"></i></div>
            </div>
        </div>

        <!-- Tabel Verifikasi Iuran -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 text-lg">Konfirmasi Pembayaran Warga</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                        <tr>
                            <th class="p-4">Nama Warga</th>
                            <th class="p-4">Bulan / Tahun</th>
                            <th class="p-4">Nominal</th>
                            <th class="p-4">Bukti Transfer</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingIuran ?? [] as $iuran)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4 font-semibold text-gray-900">{{ $iuran->user->name }}</td>
                                <td class="p-4 text-gray-600">{{ $iuran->bulan }} {{ $iuran->tahun }}</td>
                                <td class="p-4 font-bold text-emerald-600">Rp {{ number_format($iuran->nominal, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    <a href="{{ asset('storage/' . $iuran->bukti_transfer) }}" target="_blank" class="text-xs font-semibold text-indigo-600 hover:underline">
                                        <i class="fa-solid fa-image mr-1"></i>Lihat Bukti
                                    </a>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="/iuran/{{ $iuran->id }}/approve" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="/iuran/{{ $iuran->id }}/reject" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 rounded-lg text-xs font-semibold transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-400">Tidak ada pengajuan pembayaran yang perlu diverifikasi saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    {{-- ================================================================= --}}
    {{-- 3. DASHBOARD ADMIN / SUPER ADMIN (PAK RT / CENTRAL)               --}}
    {{-- ================================================================= --}}
    @else
        <!-- Hero Banner Admin -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 via-indigo-700 to-indigo-900 p-8 text-white shadow-lg">
            <div class="relative z-10 max-w-2xl space-y-3">
                <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-white backdrop-blur-md">
                    Control Center Pengurus RT
                </span>
                <h1 class="text-3xl font-extrabold sm:text-4xl">
                    Dashboard Utama Pengurus
                </h1>
                <p class="text-blue-100 text-sm sm:text-base">
                    Kelola data warga, persetujuan surat administrasi, dan publikasi pengumuman komplek.
                </p>
                <div class="pt-2 flex gap-3">
                    <a href="/pengumuman/create" class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-bold text-indigo-900 hover:bg-blue-50 transition shadow">
                        <i class="fa-solid fa-bullhorn"></i> Buat Pengumuman
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Terdaftar</p>
                    <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $totalWarga ?? 0 }} Warga</h3>
                </div>
                <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl"><i class="fa-solid fa-users text-2xl"></i></div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Surat Perlu Persetujuan</p>
                    <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $totalPendingSuratCount ?? 0 }} Pengajuan</h3>
                </div>
                <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl"><i class="fa-solid fa-file-signature text-2xl"></i></div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengumuman Aktif</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">Aktif</h3>
                </div>
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl"><i class="fa-solid fa-bullhorn text-2xl"></i></div>
            </div>
        </div>

        <!-- Tabel Pengajuan Surat Keterangan -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 text-lg">Pengajuan Surat Keterangan Warga</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                        <tr>
                            <th class="p-4">Nama Pemohon</th>
                            <th class="p-4">Jenis Surat</th>
                            <th class="p-4">Keperluan</th>
                            <th class="p-4">Tanggal Pengajuan</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingSurat ?? [] as $surat)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4 font-semibold text-gray-900">{{ $surat->user->name }}</td>
                                <td class="p-4 text-indigo-600 font-medium">{{ $surat->jenis_surat }}</td>
                                <td class="p-4 text-gray-600 max-w-xs truncate">{{ $surat->keperluan }}</td>
                                <td class="p-4 text-gray-400 text-xs">{{ $surat->created_at->format('d M Y') }}</td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="/surat/{{ $surat->id }}/approve" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="/surat/{{ $surat->id }}/reject" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 rounded-lg text-xs font-semibold transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-400">Belum ada pengajuan surat keterangan baru dari warga.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection