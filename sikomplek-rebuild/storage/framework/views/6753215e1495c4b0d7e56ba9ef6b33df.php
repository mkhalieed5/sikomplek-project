<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-xl rounded-2xl p-8">
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-indigo-100 text-indigo-600 text-2xl font-bold">S</div>
                <h1 class="mt-4 text-2xl font-bold text-slate-800">Sikomplek</h1>
                <p class="text-sm text-slate-500 mt-1">Masuk ke dashboard admin</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100" placeholder="nama@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-3 font-semibold text-white transition hover:bg-indigo-700">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="<?php echo e(route('register')); ?>" class="font-semibold text-indigo-600 hover:text-indigo-500">Daftar sekarang</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\emkha\Documents\sikomplek-rebuild\sikomplek-rebuild\resources\views/auth/login.blade.php ENDPATH**/ ?>