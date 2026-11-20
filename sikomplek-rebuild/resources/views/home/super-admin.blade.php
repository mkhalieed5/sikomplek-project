<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-950 font-sans text-slate-800">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="w-full shrink-0 bg-slate-950 text-white lg:w-72">
            <div class="border-b border-white/10 px-6 py-6"><a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-xl font-extrabold"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-cyan-400"><i class="fa-solid fa-gears"></i></span>Sikomplek <span class="text-xs font-bold text-cyan-300">ENGINE</span></a></div>
            <nav class="space-y-2 p-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl bg-white/10 px-4 py-3 text-sm font-bold text-cyan-300"><i class="fa-solid fa-chart-line w-5"></i>Overview Platform</a>
                <a href="{{ route('warga') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-300 hover:bg-white/10"><i class="fa-solid fa-users w-5"></i>Seluruh Warga</a>
                <a href="{{ route('kartu-keluarga') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-300 hover:bg-white/10"><i class="fa-solid fa-building w-5"></i>Data Komplek</a>
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="p-4 lg:mt-auto"><div class="border-t border-white/10 pt-4">@csrf<button class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-300 hover:bg-rose-500/10 hover:text-rose-300"><i class="fa-solid fa-right-from-bracket"></i>Keluar</button></div></form>
        </aside>
        <main class="min-w-0 flex-1 bg-slate-50 p-5 sm:p-8">
            <div class="mx-auto max-w-7xl space-y-8">
                <header><p class="text-sm font-bold uppercase tracking-widest text-indigo-600">Engine Web Sikomplek</p><h1 class="mt-2 text-3xl font-black text-slate-900">Halo, {{ $user->name }}</h1><p class="mt-2 text-slate-500">Pantau seluruh ekosistem komplek dari satu pusat kendali.</p></header>
                <section class="rounded-3xl bg-gradient-to-r from-slate-900 to-indigo-900 p-7 text-white shadow-xl"><p class="text-xs font-bold uppercase tracking-widest text-cyan-300">Platform control center</p><h2 class="mt-3 text-2xl font-black">Semua komplek, satu kendali.</h2><p class="mt-2 max-w-xl text-sm text-slate-300">Kelola tenant dan pertumbuhan komunitas Sikomplek secara menyeluruh.</p></section>
                <div class="grid gap-5 sm:grid-cols-3"><div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200"><p class="text-sm text-slate-500">Total Komplek</p><p class="mt-2 text-4xl font-black text-indigo-700">{{ $totalTenant }}</p></div><div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200"><p class="text-sm text-slate-500">Total Warga</p><p class="mt-2 text-4xl font-black text-slate-900">{{ $totalWarga }}</p></div><div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200"><p class="text-sm text-slate-500">Total Kartu Keluarga</p><p class="mt-2 text-4xl font-black text-slate-900">{{ $totalKk }}</p></div></div>
                <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200"><div class="border-b border-slate-100 p-6"><h2 class="font-extrabold text-slate-900">Komplek Terbaru</h2></div><div class="divide-y divide-slate-100">@forelse($recentTenants as $item)<div class="p-5"><p class="font-bold text-slate-800">{{ $item->name }}</p><p class="text-sm text-slate-500">{{ $item->address ?? 'Alamat belum diisi' }}</p></div>@empty<div class="p-6 text-sm text-slate-500">Belum ada komplek terdaftar.</div>@endforelse</div></section>
            </div>
        </main>
    </div>
</body>
</html>
