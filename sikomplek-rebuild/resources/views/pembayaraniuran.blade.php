<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Iuran - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-indigo-900 text-white flex-shrink-0 hidden md:block">
            <div class="p-5 text-2xl font-bold border-b border-indigo-800">SIKOMPLEK</div>
            <nav class="p-4 space-y-2">
                <a href="/home" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-house w-5"></i><span>Dashboard</span></a>
                <a href="/kartu-keluarga" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-id-card w-5"></i><span>Kartu Keluarga</span></a>
                <a href="/warga" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-users w-5"></i><span>Data Warga</span></a>
                <a href="/kategori-iuran" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-tags w-5"></i><span>Kategori Iuran</span></a>
                <a href="/pembayaran-iuran" class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 text-white rounded-lg font-medium"><i class="fa-solid fa-wallet w-5"></i><span>Pembayaran Iuran</span></a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm p-4 px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">Riwayat Pembayaran Iuran</h1>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition flex items-center space-x-2">
                    <i class="fa-solid fa-plus"></i><span>Catat Pembayaran</span>
                </button>
            </header>

            <main class="p-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b">
                                    <th class="p-3">KK / Warga</th>
                                    <th class="p-3">Kategori</th>
                                    <th class="p-3">Periode</th>
                                    <th class="p-3">Jumlah Bayar</th>
                                    <th class="p-3">Tgl Bayar</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y text-sm text-gray-700">
                                <tr>
                                    <td class="p-3 font-medium">Pak Slamet</td>
                                    <td class="p-3">Kebersihan & Keamanan</td>
                                    <td class="p-3">September 2026</td>
                                    <td class="p-3 font-bold">Rp 50.000</td>
                                    <td class="p-3">04 Sep 2026</td>
                                    <td class="p-3"><span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Lunas</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>