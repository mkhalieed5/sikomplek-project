<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Warga - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800">
    <main class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="grid w-full max-w-6xl overflow-hidden rounded-3xl bg-white shadow-2xl shadow-slate-300/50 lg:grid-cols-2">
            <section class="relative hidden overflow-hidden bg-slate-900 p-10 text-white lg:flex lg:flex-col lg:justify-between xl:p-14">
                <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-emerald-400/20 blur-2xl"></div>
                <div class="absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-indigo-500/20 blur-2xl"></div>

                <div class="relative">
                    <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center gap-3 text-lg font-bold tracking-tight">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 to-indigo-500 text-xl shadow-lg shadow-emerald-500/20">
                            <i class="fa-solid fa-house"></i>
                        </span>
                        Sikomplek
                    </a>
                </div>

                <div class="relative py-12">
                    <span class="mb-5 inline-flex items-center gap-2 rounded-full border border-emerald-300/20 bg-emerald-300/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-300">
                        <i class="fa-solid fa-sparkles"></i>
                        Komunitas lebih dekat
                    </span>
                    <h1 class="max-w-md text-4xl font-bold leading-tight xl:text-5xl">
                        Bergabung dengan Komunitas Komplek Anda
                    </h1>
                    <p class="mt-5 max-w-md text-base leading-7 text-slate-300">
                        Kelola informasi warga, iuran, dan kabar lingkungan dalam satu ruang digital yang aman dan mudah digunakan.
                    </p>
                </div>

                <div class="relative flex items-center gap-3 text-sm text-slate-300">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-emerald-300">
                        <i class="fa-solid fa-shield-heart"></i>
                    </span>
                    Data komunitas terlindungi dan terkelola dengan baik
                </div>
            </section>

            <section class="p-6 sm:p-10 xl:p-14">
                <div class="mx-auto max-w-xl">
                    <div class="mb-8 lg:hidden">
                        <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center gap-2 text-lg font-bold">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white">
                                <i class="fa-solid fa-house"></i>
                            </span>
                            Sikomplek
                        </a>
                    </div>

                    <div class="mb-8">
                        <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-emerald-600">Registrasi warga</p>
                        <h2 class="text-3xl font-bold tracking-tight text-slate-900">Buat akun baru</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Lengkapi data berikut untuk bergabung di lingkungan Anda.</p>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="mb-6 flex gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
                            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                            <div>
                                <p class="font-semibold">Periksa kembali data Anda.</p>
                                <p class="mt-1"><?php echo e($errors->first()); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-5" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('.submit-label').classList.add('hidden'); this.querySelector('.submit-loading').classList.remove('hidden');">
                        <?php echo csrf_field(); ?>

                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                            <div class="relative">
                                <i class="fa-regular fa-user pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name" placeholder="Contoh: Budi Santoso"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            </div>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Alamat Email</label>
                            <div class="relative">
                                <i class="fa-regular fa-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="nama@email.com"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="tenant_code" class="mb-2 block text-sm font-semibold text-slate-700">Kode Komplek / RT</label>
                            <div class="relative">
                                <i class="fa-solid fa-key pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input id="tenant_code" name="tenant_code" type="text" value="<?php echo e(old('tenant_code')); ?>" required maxlength="255" autocomplete="off" placeholder="Contoh: ILMI-RT01"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm font-semibold uppercase tracking-wide outline-none transition placeholder:font-normal placeholder:tracking-normal placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 <?php $__errorArgs = ['tenant_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            </div>
                            <p class="mt-1.5 text-xs text-slate-500"><i class="fa-solid fa-circle-info mr-1 text-emerald-600"></i>Dapatkan kode registrasi ini dari Pengurus RT / Komplek Anda.</p>
                            <?php $__errorArgs = ['tenant_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <div class="mt-5">
                                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                                <div class="relative">
                                    <i class="fa-solid fa-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Minimal 6 karakter"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                                <div class="relative">
                                    <i class="fa-solid fa-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Ulangi password"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 hover:shadow-indigo-600/30 disabled:cursor-not-allowed disabled:opacity-70">
                            <span class="submit-label"><i class="fa-solid fa-user-plus mr-2"></i>Daftar Akun Warga</span>
                            <span class="submit-loading hidden"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Mendaftarkan...</span>
                        </button>
                    </form>

                    <p class="mt-7 text-center text-sm text-slate-500">
                        Sudah punya akun?
                        <a href="<?php echo e(route('login')); ?>" class="font-bold text-indigo-600 transition hover:text-emerald-600">Masuk di sini</a>
                    </p>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
<?php /**PATH C:\Users\emkha\Documents\sikomplek-rebuild\sikomplek-rebuild\resources\views/auth/register.blade.php ENDPATH**/ ?>