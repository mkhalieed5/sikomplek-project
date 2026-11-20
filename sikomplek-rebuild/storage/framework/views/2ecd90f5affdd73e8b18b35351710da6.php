<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?php echo e($item ? 'Edit' : 'Tambah'); ?> <?php echo e($config['title']); ?></title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-100 text-slate-800">
<main class="max-w-3xl mx-auto p-6 md:p-10">
    <a href="<?php echo e(route($module)); ?>" class="text-indigo-600 text-sm">← Kembali ke <?php echo e($config['title']); ?></a>
    <section class="bg-white rounded-xl shadow-sm p-6 mt-4"><h1 class="text-2xl font-bold mb-6"><?php echo e($item ? 'Edit' : 'Tambah'); ?> <?php echo e($config['title']); ?></h1>
    <?php if($errors->any()): ?><div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4"><ul class="list-disc pl-5"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div><?php endif; ?>
    <form method="POST" action="<?php echo e($item ? route($module . '.update', $item->id) : route($module . '.store')); ?>" class="grid gap-4">
        <?php echo csrf_field(); ?> <?php if($item): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <?php $__currentLoopData = $config['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php ($value = old($field, data_get($item, $field))); ?>
            <label class="grid gap-1 text-sm font-medium"><?php echo e($field === 'owner_user_id' ? 'Akun Pemilik Data Keluarga' : ucwords(str_replace('_', ' ', $field))); ?>

            <?php if($field === 'kartu_keluarga_id'): ?><select name="<?php echo e($field); ?>" required class="border rounded-lg p-2"><option value="">Pilih KK</option><?php $__currentLoopData = $families; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($family->id); ?>" <?php if($value == $family->id): echo 'selected'; endif; ?>><?php echo e($family->nomor_kk); ?> - <?php echo e($family->nama_kepala_keluarga); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <?php elseif($field === 'owner_user_id'): ?><select name="<?php echo e($field); ?>" class="border rounded-lg p-2"><option value="">Belum ditautkan ke akun</option><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($user->id); ?>" <?php if($value == $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?> (<?php echo e($user->email); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <?php elseif($field === 'kategori_iuran_id'): ?><select name="<?php echo e($field); ?>" required class="border rounded-lg p-2"><option value="">Pilih kategori</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category->id); ?>" <?php if($value == $category->id): echo 'selected'; endif; ?>><?php echo e($category->nama_kategori); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <?php elseif(in_array($field, ['jenis_kelamin','status_pernikahan','status_keluarga','status'])): ?><select name="<?php echo e($field); ?>" required class="border rounded-lg p-2"><?php $__currentLoopData = match($field){'jenis_kelamin'=>['L','P'],'status_pernikahan'=>['Belum Menikah','Menikah','Cerai'],'status_keluarga'=>['Kepala Keluarga','Istri','Anak','Anggota'],'status'=>['lunas','pending','batal']}; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($option); ?>" <?php if($value === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <?php elseif($field === 'deskripsi' || $field === 'alamat' || $field === 'catatan'): ?><textarea name="<?php echo e($field); ?>" class="border rounded-lg p-2"><?php echo e($value); ?></textarea>
            <?php else: ?><input name="<?php echo e($field); ?>" value="<?php echo e($value); ?>" type="<?php echo e($field === 'tanggal_lahir' || $field === 'tanggal_bayar' ? 'date' : (in_array($field, ['nominal_default','jumlah_bayar','bulan','tahun']) ? 'number' : 'text')); ?>" <?php if (! (in_array($field, ['pekerjaan','nomor_hp']))): ?> required <?php endif; ?> class="border rounded-lg p-2"><?php endif; ?>
            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <button class="bg-indigo-600 text-white rounded-lg p-3 mt-2">Simpan</button>
    </form></section>
</main>
</body>
</html>
<?php /**PATH C:\Users\emkha\Downloads\sikomplek-rebuild\sikomplek-rebuild\resources\views/crud/form.blade.php ENDPATH**/ ?>