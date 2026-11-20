<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#f8fbff] font-sans text-[#102a43] antialiased">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="w-full shrink-0 border-b border-[#e5edf5] bg-white lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r">
            <div class="flex items-center justify-between border-b border-[#e5edf5] px-6 py-5">
                <a href="{{ url('/') }}" class="flex items-center gap-3 text-xl font-extrabold tracking-tight">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-[#1769e0] to-[#55a5ff] text-lg text-white shadow-lg shadow-blue-500/20">
                        <i class="fa-solid fa-house"></i>
                    </span>
                    Sikomplek
                </a>
                <span class="rounded-full bg-[#effcf9] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#168d79]">Warga</span>
            </div>

            <nav class="flex gap-2 overflow-x-auto p-4 lg:block lg:space-y-2">
                <a href="{{ route('dashboard') }}" class="flex min-w-max items-center gap-3 rounded-xl bg-[#edf5ff] px-4 py-3 text-sm font-bold text-[#1769e0]">
                    <i class="fa-solid fa-house w-5 text-center"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('kartu-keluarga') }}" class="flex min-w-max items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#64748b] transition hover:bg-[#f7fbff] hover:text-[#1769e0]">
                    <i class="fa-solid fa-id-card w-5 text-center"></i><span>Kartu Keluarga</span>
                </a>
                <a href="{{ route('warga') }}" class="flex min-w-max items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#64748b] transition hover:bg-[#f7fbff] hover:text-[#1769e0]">
                    <i class="fa-solid fa-users w-5 text-center"></i><span>Data Warga</span>
                </a>
                <a href="{{ route('iuran') }}" class="flex min-w-max items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#64748b] transition hover:bg-[#f7fbff] hover:text-[#1769e0]">
                    <i class="fa-solid fa-wallet w-5 text-center"></i><span>Iuran & Kas</span>
                </a>
            </nav>

            <div class="hidden px-6 pb-6 lg:block">
                <div class="rounded-2xl bg-gradient-to-br from-[#1769e0] to-[#2f86ed] p-5 text-white shadow-lg shadow-blue-500/15">
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-100">Sikomplek</p>
                    <p class="mt-2 text-sm font-semibold">Kelola komplek lebih mudah dan transparan.</p>
                    <span class="mt-4 inline-flex items-center gap-2 text-xs text-blue-100"><i class="fa-solid fa-shield-heart text-[#19b394]"></i> Aman untuk komunitas</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-semibold text-[#64748b] transition hover:bg-rose-50 hover:text-rose-600">
                        <i class="fa-solid fa-right-from-bracket text-rose-500"></i>
                        <span>Keluar / Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="border-b border-[#e5edf5] bg-white/90 px-5 py-4 backdrop-blur sm:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-[#19b394]">Ringkasan komplek</p>
                        <h1 class="mt-1 text-xl font-extrabold tracking-tight text-[#102a43] sm:text-2xl">{{ $tenant?->name ?? 'Dashboard Sikomplek' }}</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden text-right sm:block">
                            <span class="block text-sm font-bold text-[#102a43]">Halo, {{ auth()->user()->name }}</span>
                            @if (auth()->user()->role === 'tenant_admin')
                                <span class="block text-xs text-[#64748b]">{{ $tenant?->code }}</span>
                            @else
                                <span class="block text-xs text-[#64748b]">{{ auth()->user()->role === 'super_admin' ? 'Super Admin' : ($tenant?->name ?? 'Warga') }}</span>
                            @endif
                        </span>
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-[#1769e0] to-[#55a5ff] font-bold text-white shadow-lg shadow-blue-500/20">A</div>
                        <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                            @csrf
                            <button type="submit" aria-label="Keluar" class="flex h-10 w-10 items-center justify-center rounded-xl text-[#64748b] transition hover:bg-rose-50 hover:text-rose-600">
                                <i class="fa-solid fa-right-from-bracket text-rose-500"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="relative flex-1 overflow-hidden p-5 sm:p-8">
                <div class="pointer-events-none absolute -right-32 -top-32 h-80 w-80 rounded-full bg-[#e4f7f3] opacity-70 blur-3xl"></div>
                <div class="relative mx-auto max-w-7xl space-y-8">
                    <section class="rounded-3xl bg-gradient-to-r from-[#135ed1] to-[#2f86ed] p-6 text-white shadow-xl shadow-blue-500/15 sm:p-8">
                        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
                            <div>
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-blue-100"><span class="h-1.5 w-1.5 rounded-full bg-[#19b394]"></span>Komunitas terhubung</span>
                                <h2 class="mt-4 text-2xl font-extrabold tracking-tight sm:text-3xl">Komplek rapi, warga happy.</h2>
                                <p class="mt-2 max-w-xl text-sm leading-6 text-blue-100">{{ $tenant?->address ?? 'Pantau data warga, iuran, dan aktivitas lingkungan dalam satu ruang yang terorganisir.' }}</p>
                            </div>
                            <div class="hidden h-20 w-20 items-center justify-center rounded-3xl bg-white/10 text-4xl text-white/80 md:flex"><i class="fa-solid fa-city"></i></div>
                        </div>
                    </section>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-2xl border border-[#e5edf5] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-start justify-between"><div><p class="text-sm font-semibold text-[#64748b]">Total KK</p><h3 class="mt-2 text-3xl font-extrabold text-[#102a43]">{{ $totalKk }}</h3></div><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf5ff] text-lg text-[#1769e0]"><i class="fa-solid fa-house-user"></i></span></div>
                            <p class="mt-4 text-xs text-[#19b394]"><i class="fa-solid fa-arrow-trend-up mr-1"></i> Data terkelola</p>
                        </div>
                        <div class="rounded-2xl border border-[#e5edf5] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-start justify-between"><div><p class="text-sm font-semibold text-[#64748b]">Total Warga</p><h3 class="mt-2 text-3xl font-extrabold text-[#102a43]">{{ $totalWarga }}</h3></div><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#effcf9] text-lg text-[#19b394]"><i class="fa-solid fa-users"></i></span></div>
                            <p class="mt-4 text-xs text-[#64748b]"><i class="fa-solid fa-user-check mr-1 text-[#19b394]"></i> Warga aktif</p>
                        </div>
                        <div class="rounded-2xl border border-[#e5edf5] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-start justify-between"><div><p class="text-sm font-semibold text-[#64748b]">Pemasukan Bulan Ini</p><h3 class="mt-2 text-2xl font-extrabold text-[#102a43]">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</h3></div><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#effcf9] text-lg text-[#168d79]"><i class="fa-solid fa-money-bill-wave"></i></span></div>
                            <p class="mt-4 text-xs text-[#19b394]"><i class="fa-solid fa-arrow-trend-up mr-1"></i> Keuangan transparan</p>
                        </div>
                        <div class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-start justify-between"><div><p class="text-sm font-semibold text-[#64748b]">Belum Bayar Iuran</p><h3 class="mt-2 text-3xl font-extrabold text-red-600">{{ max(0, $belumBayar) }} <span class="text-sm font-semibold text-[#64748b]">KK</span></h3></div><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-lg text-red-500"><i class="fa-solid fa-circle-exclamation"></i></span></div>
                            <p class="mt-4 text-xs text-red-500"><i class="fa-solid fa-clock mr-1"></i> Perlu ditindaklanjuti</p>
                        </div>
                    </div>

                    <section class="overflow-hidden rounded-3xl border border-[#e5edf5] bg-white shadow-sm">
                        <div class="flex flex-col gap-3 border-b border-[#e5edf5] p-6 sm:flex-row sm:items-center sm:justify-between">
                            <div><p class="text-xs font-bold uppercase tracking-wider text-[#19b394]">Aktivitas keuangan</p><h2 class="mt-1 text-lg font-extrabold text-[#102a43]">Pembayaran Iuran Terakhir</h2></div>
                            <a href="{{ route('pembayaran-iuran') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#1769e0] transition hover:text-[#19b394]">Lihat Semua <i class="fa-solid fa-arrow-right text-xs"></i></a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[680px] text-left">
                                <thead><tr class="bg-[#f8fbff] text-xs uppercase tracking-wider text-[#64748b]"><th class="px-6 py-4">Nama Kepala Keluarga</th><th class="px-6 py-4">Kategori</th><th class="px-6 py-4">Bulan / Tahun</th><th class="px-6 py-4">Jumlah</th><th class="px-6 py-4">Status</th></tr></thead>
                                <tbody class="divide-y divide-[#e5edf5] text-sm text-[#102a43]">
                                    @forelse($recentPayments as $payment)
                                        <tr class="transition hover:bg-[#f8fbff]">
                                            <td class="px-6 py-4 font-bold">{{ $payment->kartuKeluarga?->nama_kepala_keluarga ?? 'Tanpa nama' }}</td>
                                            <td class="px-6 py-4 text-[#64748b]">{{ $payment->kategoriIuran?->nama_kategori ?? 'Iuran warga' }}</td>
                                            <td class="px-6 py-4 text-[#64748b]">{{ $payment->tanggal_bayar?->format('F Y') ?? '-' }}</td>
                                            <td class="px-6 py-4 font-semibold">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4"><span class="inline-flex items-center gap-1.5 rounded-full bg-[#effcf9] px-2.5 py-1 text-xs font-bold text-[#168d79]"><i class="fa-solid fa-check text-[10px]"></i>{{ ucfirst($payment->status) }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="px-6 py-10 text-center text-sm text-[#64748b]">Belum ada pembayaran untuk {{ $tenant?->name ?? 'komplek ini' }}.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
