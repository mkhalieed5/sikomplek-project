<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komplek Berhasil Didaftarkan - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 p-4 font-sans text-slate-800">
    <main class="w-full max-w-lg rounded-3xl bg-white p-8 text-center shadow-xl sm:p-12">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-2xl text-emerald-700">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <h1 class="mt-6 text-2xl font-bold text-slate-900">Komplek berhasil didaftarkan</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">{{ session('success') }}</p>
        <p class="mt-6 text-sm font-semibold text-slate-700">Simpan kode ini untuk dibagikan kepada warga:</p>
        <strong class="mt-2 inline-block rounded-xl bg-indigo-50 px-5 py-3 text-xl tracking-widest text-indigo-700">{{ session('tenant_code') }}</strong>
        <p class="mt-3 text-xs text-slate-500">Warga membutuhkan kode ini saat membuat akun.</p>
        <a href="{{ url('/home') }}" class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 font-bold text-white transition hover:bg-indigo-700">Lanjut ke Dashboard</a>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
