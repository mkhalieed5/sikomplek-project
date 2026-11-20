<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Iuran - Sikomplek</title>
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
                <a href="/kategori-iuran" class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 text-white rounded-lg font-medium"><i class="fa-solid fa-tags w-5"></i><span>Kategori Iuran</span></a>
                <a href="/pembayaran-iuran" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-wallet w-5"></i><span>Pembayaran Iuran</span></a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm p-4 px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">Kategori Tagihan Iuran</h1>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition flex items-center space-x-2">
                    <i class="fa-solid fa-plus"></i><span>Tambah Kategori</span>
                </button>
            </header>

            <main class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div>
                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full">Tagihan Bulanan</span>
                            <h3 class="text-lg font-bold text-gray-800 mt-2">Kebersihan & Keamanan</h3>
                            <p class="text-sm text-gray-500 mt-1">Iuran rutin bulanan untuk kas RT dan petugas sampah.</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-50 flex justify-between items-center">
                            <span class="text-xl font-extrabold text-indigo-900">Rp 50.000</span>
                            <button class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Edit</button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>