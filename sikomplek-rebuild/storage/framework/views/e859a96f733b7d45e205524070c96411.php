<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Warga - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#f8fbff] font-sans text-[#102a43]">
    <main class="mx-auto min-h-screen max-w-5xl p-5 sm:p-8">
        <header class="flex items-center justify-between"><div><p class="text-xs font-bold uppercase tracking-widest text-[#19b394]">Portal Warga</p><h1 class="mt-2 text-3xl font-black"><?php echo e($user->name); ?></h1><p class="mt-2 text-sm text-[#64748b]"><?php echo e($tenant?->name ?? 'Komplek Anda'); ?></p></div><form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-rose-50 hover:text-rose-600"><i class="fa-solid fa-right-from-bracket mr-2 text-rose-500"></i>Keluar</button></form></header>
        <section class="mt-8 rounded-3xl bg-gradient-to-r from-[#135ed1] to-[#2f86ed] p-7 text-white shadow-xl"><span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-wider">Warga terdaftar</span><h2 class="mt-4 text-3xl font-black">Selamat datang di <?php echo e($tenant?->name ?? 'komplek Anda'); ?>.</h2><p class="mt-2 text-blue-100">Akses layanan warga, informasi lingkungan, dan status iuran Anda dari sini.</p></section>
        <div class="mt-8 grid gap-5 sm:grid-cols-2"><a href="<?php echo e(route('iuran')); ?>" class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#e5edf5] transition hover:-translate-y-1 hover:shadow-lg"><span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#effcf9] text-xl text-[#168d79]"><i class="fa-solid fa-wallet"></i></span><h3 class="mt-5 text-lg font-extrabold">Iuran Saya</h3><p class="mt-2 text-sm text-[#64748b]">Lihat informasi dan status pembayaran iuran.</p></a><a href="<?php echo e(route('kartu-keluarga')); ?>" class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#e5edf5] transition hover:-translate-y-1 hover:shadow-lg"><span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#edf5ff] text-xl text-[#1769e0]"><i class="fa-solid fa-id-card"></i></span><h3 class="mt-5 text-lg font-extrabold">Data Kartu Keluarga</h3><p class="mt-2 text-sm text-[#64748b]">Akses data keluarga yang terhubung dengan komplek.</p></a></div>
        <div class="mt-8 rounded-2xl border border-[#ccefe7] bg-[#effcf9] p-5 text-sm text-[#168d79]"><i class="fa-solid fa-circle-info mr-2"></i>Untuk perubahan data atau bantuan, silakan hubungi Pengurus RT <?php echo e($tenant?->name ?? ''); ?>.</div>
    </main>
</body>
</html>
<?php /**PATH C:\Users\emkha\Documents\sikomplek-rebuild\sikomplek-rebuild\resources\views/home/warga.blade.php ENDPATH**/ ?>