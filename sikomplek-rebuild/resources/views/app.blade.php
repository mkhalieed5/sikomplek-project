<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SI-KOMPLEK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-800 text-white flex flex-col justify-between p-4">
            <div>
                <h1 class="text-xl font-bold border-b border-slate-700 pb-4 mb-4">SI-KOMPLEK</h1>
                <nav class="space-y-2">
                    <a href="/dashboard" class="block py-2 px-4 rounded bg-slate-700 font-medium">
                        <i class="fa-solid fa-gauge mr-2"></i> Dashboard
                    </a>
                    
                    <!-- Menu khusus Admin / RT -->
                    @if(in_array(auth()->user()->role, ['super_admin', 'tenant_admin']))
                        <a href="/warga" class="block py-2 px-4 rounded hover:bg-slate-700 text-gray-300">
                            <i class="fa-solid fa-users mr-2"></i> Data Warga
                        </a>
                        <a href="/pengumuman" class="block py-2 px-4 rounded hover:bg-slate-700 text-gray-300">
                            <i class="fa-solid fa-bullhorn mr-2"></i> Pengumuman
                        </a>
                    @endif

                    <!-- Menu khusus Bendahara -->
                    @if(in_array(auth()->user()->role, ['super_admin', 'bendahara']))
                        <a href="/iuran" class="block py-2 px-4 rounded hover:bg-slate-700 text-gray-300">
                            <i class="fa-solid fa-wallet mr-2"></i> Kelola Iuran
                        </a>
                        <a href="/laporan" class="block py-2 px-4 rounded hover:bg-slate-700 text-gray-300">
                            <i class="fa-solid fa-file-invoice-dollar mr-2"></i> Laporan Keuangan
                        </a>
                    @endif

                    <!-- Menu Warga -->
                    @if(auth()->user()->role === 'warga')
                        <a href="/iuran-saya" class="block py-2 px-4 rounded hover:bg-slate-700 text-gray-300">
                            <i class="fa-solid fa-receipt mr-2"></i> Tagihan Saya
                        </a>
                    @endif
                </nav>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-gray-600 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition">
                        <i class="fa-solid fa-right-from-bracket text-rose-500"></i>
                        <span>Keluar / Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
            <!-- Header Ringkas -->
            <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Halo, {{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-500 capitalize">Role: {{ str_replace('_', ' ', auth()->user()->role) }}</p>
                </div>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Aktif</span>
            </div>

            <!-- Yield Content Per Role -->
            @yield('content')
        </main>
    </div>
</body>
</html>