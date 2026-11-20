<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Keluarga - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-indigo-900 text-white flex-shrink-0 hidden md:block">
            <div class="p-5 text-2xl font-bold border-b border-indigo-800">SIKOMPLEK</div>
            <nav class="p-4 space-y-2">
                <a href="/home" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-house w-5"></i><span>Dashboard</span></a>
                <a href="/kartu-keluarga" class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 text-white rounded-lg font-medium"><i class="fa-solid fa-id-card w-5"></i><span>Kartu Keluarga</span></a>
                <a href="/warga" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-users w-5"></i><span>Data Warga</span></a>
                <a href="/kategori-iuran" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-tags w-5"></i><span>Kategori Iuran</span></a>
                <a href="/pembayaran-iuran" class="flex items-center space-x-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-lg"><i class="fa-solid fa-wallet w-5"></i><span>Pembayaran Iuran</span></a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm p-4 px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">Manajemen Kartu Keluarga (KK)</h1>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition flex items-center space-x-2">
                    <i class="fa-solid fa-plus"></i><span>Tambah KK</span>
                </button>
            </header>

            <main class="p-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b">
                                    <th class="p-3">No. KK</th>
                                    <th class="p-3">Kepala Keluarga</th>
                                    <th class="p-3">Alamat</th>
                                    <th class="p-3">RT/RW</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y text-sm text-gray-700">
                                <tr>
                                    <td class="p-3 font-mono font-bold text-indigo-600">3201123456780001</td>
                                    <td class="p-3 font-medium">Pak Slamet</td>
                                    <td class="p-3">Jl. Mawar No. 10</td>
                                    <td class="p-3">001 / 005</td>
                                    <td class="p-3 text-center space-x-2">
                                        <button class="text-blue-600 hover:underline"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="text-red-600 hover:underline"><i class="fa-solid fa-trash"></i></button>
                                    </td>
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