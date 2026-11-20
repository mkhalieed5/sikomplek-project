<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Komplek RT - Sikomplek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800">
    <main class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="grid w-full max-w-6xl overflow-hidden rounded-3xl bg-white shadow-2xl shadow-slate-300/50 lg:grid-cols-2">
            <section class="relative hidden overflow-hidden bg-gradient-to-br from-indigo-950 via-indigo-900 to-blue-800 p-10 text-white lg:flex lg:flex-col lg:justify-between xl:p-14">
                <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-blue-400/20 blur-3xl"></div>
                <div class="absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-indigo-400/20 blur-3xl"></div>
                <a href="<?php echo e(url('/')); ?>" class="relative inline-flex items-center gap-3 text-lg font-bold">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15 text-xl"><i class="fa-solid fa-building-shield"></i></span>
                    Sikomplek Admin
                </a>
                <div class="relative py-12">
                    <span class="mb-5 inline-flex rounded-full border border-blue-200/20 bg-white/10 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-blue-100">Portal Pengurus RT</span>
                    <h1 class="max-w-md text-4xl font-bold leading-tight xl:text-5xl">Bangun ruang digital untuk komplek Anda.</h1>
                    <p class="mt-5 max-w-md leading-7 text-blue-100/80">Daftarkan komplek, bagikan informasi, dan kelola data warga secara lebih rapi dalam satu platform.</p>
                </div>
                <div class="relative flex items-center gap-3 text-sm text-blue-100/80">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10"><i class="fa-solid fa-shield-halved"></i></span>
                    Kode komplek unik dibuat otomatis setelah pendaftaran
                </div>
            </section>

            <section class="p-6 sm:p-10 xl:p-14">
                <div class="mx-auto max-w-xl">
                    <div class="mb-8 lg:hidden">
                        <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center gap-2 text-lg font-bold">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white"><i class="fa-solid fa-building-shield"></i></span>
                            Sikomplek Admin
                        </a>
                    </div>
                    <div class="mb-8">
                        <p class="mb-2 text-sm font-bold uppercase tracking-wider text-indigo-600">Registrasi Tenant Admin</p>
                        <h2 class="text-3xl font-bold tracking-tight text-slate-900">Daftarkan Komplek Anda</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Buat akun Pak RT dan dapatkan kode registrasi warga.</p>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                            <p class="font-bold"><i class="fa-solid fa-circle-check mr-2"></i><?php echo e(session('success')); ?></p>
                            <p class="mt-2">Kode Komplek Anda:</p>
                            <strong class="mt-1 inline-block rounded-lg bg-white px-3 py-2 text-lg tracking-widest text-indigo-700"><?php echo e(session('tenant_code')); ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <p class="font-semibold"><i class="fa-solid fa-circle-exclamation mr-2"></i>Periksa kembali data Anda.</p>
                            <p class="mt-1"><?php echo e($errors->first()); ?></p>
                        </div>
                    <?php endif; ?>

                    <form id="register-rt-form" method="POST" action="<?php echo e(route('register-rt')); ?>" class="space-y-5">
                        <?php echo csrf_field(); ?>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Pengurus RT</label>
                                <div class="relative"><i class="fa-regular fa-user pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i><input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" required autofocus placeholder="Nama Pak RT" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></div>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                                <div class="relative"><i class="fa-regular fa-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i><input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required placeholder="rt@email.com" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div>
                            <label for="nama_komplek" class="mb-2 block text-sm font-semibold text-slate-700">Nama Perumahan / Komplek RT</label>
                            <div class="relative"><i class="fa-solid fa-building pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i><input id="nama_komplek" name="nama_komplek" type="text" value="<?php echo e(old('nama_komplek')); ?>" required placeholder="Contoh: Perumahan Dar El-Ilmi RT 01" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['nama_komplek'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></div>
                            <?php $__errorArgs = ['nama_komplek'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <fieldset class="space-y-5 rounded-2xl border border-slate-200 p-4 sm:p-5">
                            <legend class="px-2 text-sm font-bold text-slate-800">Alamat Komplek</legend>
                            <div>
                                <label for="alamat_jalan" class="mb-2 block text-sm font-semibold text-slate-700">Alamat Jalan / Blok / Nomor</label>
                                <textarea id="alamat_jalan" name="alamat_jalan" rows="2" required maxlength="500" autocomplete="street-address" placeholder="Contoh: Jl. Mawar No. 12-B" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['alamat_jalan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('alamat_jalan', old('alamat'))); ?></textarea>
                                <?php $__errorArgs = ['alamat_jalan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <p class="text-xs leading-5 text-slate-500">Pilih wilayah secara berurutan. Daftar wilayah dimuat dari layanan data wilayah Indonesia; kode pos diisi manual.</p>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <?php $__currentLoopData = [
                                    ['province_id', 'Provinsi'],
                                    ['regency_id', 'Kabupaten / Kota'],
                                    ['district_id', 'Kecamatan'],
                                    ['village_id', 'Kelurahan / Desa'],
                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$field, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <label for="<?php echo e($field); ?>" class="mb-2 block text-sm font-semibold text-slate-700"><?php echo e($label); ?></label>
                                        <select id="<?php echo e($field); ?>" name="<?php echo e($field); ?>" required disabled class="region-select w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = [$field];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">Memuat <?php echo e(strtolower($label)); ?>...</option>
                                        </select>
                                        <?php $__errorArgs = [$field];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div>
                                    <label for="kode_pos" class="mb-2 block text-sm font-semibold text-slate-700">Kode Pos <span class="font-normal text-slate-400">(opsional)</span></label>
                                    <input id="kode_pos" name="kode_pos" type="text" inputmode="numeric" autocomplete="postal-code" maxlength="5" pattern="[0-9]{5}" value="<?php echo e(old('kode_pos')); ?>" placeholder="Contoh: 28282" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['kode_pos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['kode_pos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <p id="region-error" class="hidden text-sm text-red-600" role="alert"></p>
                        </fieldset>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                                <div class="relative"><i class="fa-solid fa-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i><input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" aria-describedby="password-length-error" placeholder="Minimal 8 karakter" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></div>
                                <p id="password-length-error" class="mt-1.5 hidden text-xs text-red-600" role="alert">Password harus memiliki minimal 8 karakter.</p>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                                <div class="relative"><i class="fa-solid fa-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" aria-describedby="password-confirmation-error" placeholder="Ulangi password" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"></div>
                                <p id="password-confirmation-error" class="mt-1.5 hidden text-xs text-red-600" role="alert">Konfirmasi password harus sama dengan password.</p>
                            </div>
                        </div>
                        <button type="submit" class="flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-70">
                            <span class="label"><i class="fa-solid fa-building-circle-check mr-2"></i>Daftarkan Komplek Saya</span>
                            <span class="loading hidden"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Mendaftarkan...</span>
                        </button>
                    </form>
                    <p class="mt-7 text-center text-sm text-slate-500">Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="font-bold text-indigo-600 hover:text-blue-600">Masuk di sini</a></p>
                </div>
            </section>
        </div>
    </main>
<script>
    (() => {
        const fields = [
            { id: 'province_id', endpoint: 'provinces.json' },
            { id: 'regency_id', parent: 'province_id', endpoint: (id) => `regencies/${encodeURIComponent(id)}.json` },
            { id: 'district_id', parent: 'regency_id', endpoint: (id) => `districts/${encodeURIComponent(id)}.json` },
            { id: 'village_id', parent: 'district_id', endpoint: (id) => `villages/${encodeURIComponent(id)}.json` },
        ];
        const baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api/';
        const errorMessage = document.getElementById('region-error');
        const controllers = {};
        const form = document.getElementById('register-rt-form');
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const passwordLengthError = document.getElementById('password-length-error');
        const passwordConfirmationError = document.getElementById('password-confirmation-error');
        const oldValues = {
            province_id: <?php echo json_encode(old('province_id'), 15, 512) ?>,
            regency_id: <?php echo json_encode(old('regency_id'), 15, 512) ?>,
            district_id: <?php echo json_encode(old('district_id'), 15, 512) ?>,
            village_id: <?php echo json_encode(old('village_id'), 15, 512) ?>,
        };

        function validatePasswords() {
            const passwordTooShort = password.value.length > 0 && password.value.length < 8;
            const confirmationMismatch = passwordConfirmation.value.length > 0
                && passwordConfirmation.value !== password.value;

            password.setCustomValidity(passwordTooShort ? 'Password harus memiliki minimal 8 karakter.' : '');
            passwordConfirmation.setCustomValidity(confirmationMismatch ? 'Konfirmasi password harus sama dengan password.' : '');
            passwordLengthError.classList.toggle('hidden', !passwordTooShort);
            passwordConfirmationError.classList.toggle('hidden', !confirmationMismatch);
            password.classList.toggle('border-red-400', passwordTooShort);
            passwordConfirmation.classList.toggle('border-red-400', confirmationMismatch);
        }

        password.addEventListener('input', validatePasswords);
        passwordConfirmation.addEventListener('input', validatePasswords);

        function resetSelect(field, label) {
            controllers[field.id]?.abort();
            delete controllers[field.id];
            const select = document.getElementById(field.id);
            select.replaceChildren(new Option(`Pilih ${label}`, ''));
            select.disabled = true;
        }

        async function loadOptions(field, selectedValue = '') {
            const select = document.getElementById(field.id);
            const label = select.previousElementSibling.textContent.trim();
            const parentValue = field.parent ? document.getElementById(field.parent).value : '';

            resetSelect(field, label);
            if (field.parent && !parentValue) return;

            const endpoint = typeof field.endpoint === 'function'
                ? field.endpoint(parentValue)
                : field.endpoint;
            const controller = new AbortController();
            controllers[field.id] = controller;
            const timeout = setTimeout(() => controller.abort(), 10000);

            try {
                const response = await fetch(`${baseUrl}${endpoint}`, {
                    headers: { Accept: 'application/json' },
                    signal: controller.signal,
                });
                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const locations = await response.json();
                if (controllers[field.id] !== controller) return;
                for (const location of locations) {
                    select.add(new Option(location.name, location.id));
                }
                select.disabled = false;
                if (selectedValue && [...select.options].some((option) => option.value === selectedValue)) {
                    select.value = selectedValue;
                }
                errorMessage.classList.add('hidden');
            } catch (error) {
                if (controllers[field.id] !== controller) return;
                errorMessage.textContent = 'Daftar wilayah tidak dapat dimuat. Periksa koneksi Anda lalu muat ulang halaman.';
                errorMessage.classList.remove('hidden');
                console.error('Gagal memuat data wilayah:', error);
            } finally {
                clearTimeout(timeout);
            }
        }

        fields.forEach((field) => {
            document.getElementById(field.id).addEventListener('change', async () => {
                const index = fields.findIndex((item) => item.id === field.id);
                for (const dependent of fields.slice(index + 1)) {
                    resetSelect(dependent, document.querySelector(`label[for="${dependent.id}"]`).textContent.trim());
                }
                if (fields[index + 1]) {
                    await loadOptions(fields[index + 1]);
                }
            });
        });

        form.addEventListener('submit', (event) => {
            const incompleteField = fields.find((field) => !document.getElementById(field.id).value);
            if (incompleteField) {
                event.preventDefault();
                errorMessage.textContent = 'Pilih provinsi, kabupaten/kota, kecamatan, dan kelurahan/desa sebelum melanjutkan.';
                errorMessage.classList.remove('hidden');
                const select = document.getElementById(incompleteField.id);
                if (!select.disabled) select.focus();
                return;
            }

            const button = form.querySelector('button[type="submit"]');
            button.disabled = true;
            button.querySelector('.label').classList.add('hidden');
            button.querySelector('.loading').classList.remove('hidden');
        });

        (async () => {
            for (const field of fields) {
                await loadOptions(field, oldValues[field.id] ?? '');
                if (field.parent && !document.getElementById(field.id).value) break;
            }
        })();
    })();
</script>
</body>
</html>
<?php /**PATH C:\Users\emkha\Documents\sikomplek-rebuild\sikomplek-rebuild\resources\views/auth/register-rt.blade.php ENDPATH**/ ?>