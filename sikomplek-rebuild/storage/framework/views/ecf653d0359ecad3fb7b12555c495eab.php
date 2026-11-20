<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?php echo e($config['title']); ?> - Sikomplek</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-100 text-slate-800">
<main class="max-w-7xl mx-auto p-6 md:p-10">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div><a href="<?php echo e(route('dashboard')); ?>" class="text-indigo-600 text-sm">← Dashboard</a><h1 class="text-3xl font-bold mt-2"><?php echo e($config['title']); ?></h1></div>
        <a href="<?php echo e(route($module . '.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">+ Tambah <?php echo e($config['title']); ?></a>
    </div>
    <?php if(session('success')): ?><div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4"><?php echo e(session('success')); ?></div><?php endif; ?>
    <section class="bg-white rounded-xl shadow-sm overflow-x-auto">
        <table class="w-full text-left text-sm"><thead class="bg-slate-50 text-slate-500 uppercase text-xs"><tr>
            <?php $__currentLoopData = $config['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><th class="p-4"><?php echo e(str_replace('_', ' ', $field)); ?></th><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><th class="p-4">Aksi</th>
        </tr></thead><tbody class="divide-y">
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr>
            <?php $__currentLoopData = $config['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><td class="p-4"><?php echo e(data_get($item, $field) ?? '-'); ?></td><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <td class="p-4 whitespace-nowrap"><a class="text-indigo-600 mr-3" href="<?php echo e(route($module . '.edit', $item->id)); ?>">Edit</a><form class="inline" method="POST" action="<?php echo e(route($module . '.destroy', $item->id)); ?>" onsubmit="return confirm('Hapus data ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-red-600">Hapus</button></form></td>
        </tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="<?php echo e(count($config['fields']) + 1); ?>" class="p-10 text-center text-slate-500">Belum ada data.</td></tr><?php endif; ?>
        </tbody></table>
    </section>
</main>
</body>
</html>
<?php /**PATH C:\Users\emkha\Documents\sikomplek-rebuild\sikomplek-rebuild\resources\views/crud/index.blade.php ENDPATH**/ ?>