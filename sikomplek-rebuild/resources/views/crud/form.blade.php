<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>{{ $item ? 'Edit' : 'Tambah' }} {{ $config['title'] }}</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-100 text-slate-800">
<main class="max-w-3xl mx-auto p-6 md:p-10">
    <a href="{{ route($module) }}" class="text-indigo-600 text-sm">← Kembali ke {{ $config['title'] }}</a>
    <section class="bg-white rounded-xl shadow-sm p-6 mt-4"><h1 class="text-2xl font-bold mb-6">{{ $item ? 'Edit' : 'Tambah' }} {{ $config['title'] }}</h1>
    @if($errors->any())<div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ $item ? route($module . '.update', $item->id) : route($module . '.store') }}" class="grid gap-4">
        @csrf @if($item) @method('PUT') @endif
        @foreach($config['fields'] as $field)
            @php($value = old($field, data_get($item, $field)))
            <label class="grid gap-1 text-sm font-medium">{{ $field === 'owner_user_id' ? 'Akun Pemilik Data Keluarga' : ucwords(str_replace('_', ' ', $field)) }}
            @if($field === 'kartu_keluarga_id')<select name="{{ $field }}" required class="border rounded-lg p-2"><option value="">Pilih KK</option>@foreach($families as $family)<option value="{{ $family->id }}" @selected($value == $family->id)>{{ $family->nomor_kk }} - {{ $family->nama_kepala_keluarga }}</option>@endforeach</select>
            @elseif($field === 'owner_user_id')<select name="{{ $field }}" class="border rounded-lg p-2"><option value="">Belum ditautkan ke akun</option>@foreach($users as $user)<option value="{{ $user->id }}" @selected($value == $user->id)>{{ $user->name }} ({{ $user->email }})</option>@endforeach</select>
            @elseif($field === 'kategori_iuran_id')<select name="{{ $field }}" required class="border rounded-lg p-2"><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected($value == $category->id)>{{ $category->nama_kategori }}</option>@endforeach</select>
            @elseif(in_array($field, ['jenis_kelamin','status_pernikahan','status_keluarga','status']))<select name="{{ $field }}" required class="border rounded-lg p-2">@foreach(match($field){'jenis_kelamin'=>['L','P'],'status_pernikahan'=>['Belum Menikah','Menikah','Cerai'],'status_keluarga'=>['Kepala Keluarga','Istri','Anak','Anggota'],'status'=>['lunas','pending','batal']} as $option)<option value="{{ $option }}" @selected($value === $option)>{{ $option }}</option>@endforeach</select>
            @elseif($field === 'deskripsi' || $field === 'alamat' || $field === 'catatan')<textarea name="{{ $field }}" class="border rounded-lg p-2">{{ $value }}</textarea>
            @else<input name="{{ $field }}" value="{{ $value }}" type="{{ $field === 'tanggal_lahir' || $field === 'tanggal_bayar' ? 'date' : (in_array($field, ['nominal_default','jumlah_bayar','bulan','tahun']) ? 'number' : 'text') }}" @unless(in_array($field, ['pekerjaan','nomor_hp'])) required @endunless class="border rounded-lg p-2">@endif
            </label>
        @endforeach
        <button class="bg-indigo-600 text-white rounded-lg p-3 mt-2">Simpan</button>
    </form></section>
</main>
</body>
</html>
