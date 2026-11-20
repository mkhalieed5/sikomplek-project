<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>{{ $config['title'] }} - Sikomplek</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-100 text-slate-800">
<main class="max-w-7xl mx-auto p-6 md:p-10">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div><a href="{{ route('dashboard') }}" class="text-indigo-600 text-sm">← Dashboard</a><h1 class="text-3xl font-bold mt-2">{{ $config['title'] }}</h1></div>
        <a href="{{ route($module . '.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">+ Tambah {{ $config['title'] }}</a>
    </div>
    @if(session('success'))<div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">{{ session('success') }}</div>@endif
    <section class="bg-white rounded-xl shadow-sm overflow-x-auto">
        <table class="w-full text-left text-sm"><thead class="bg-slate-50 text-slate-500 uppercase text-xs"><tr>
            @foreach($config['fields'] as $field)<th class="p-4">{{ str_replace('_', ' ', $field) }}</th>@endforeach<th class="p-4">Aksi</th>
        </tr></thead><tbody class="divide-y">
        @forelse($items as $item)<tr>
            @foreach($config['fields'] as $field)<td class="p-4">{{ data_get($item, $field) ?? '-' }}</td>@endforeach
            <td class="p-4 whitespace-nowrap"><a class="text-indigo-600 mr-3" href="{{ route($module . '.edit', $item->id) }}">Edit</a><form class="inline" method="POST" action="{{ route($module . '.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form></td>
        </tr>@empty<tr><td colspan="{{ count($config['fields']) + 1 }}" class="p-10 text-center text-slate-500">Belum ada data.</td></tr>@endforelse
        </tbody></table>
    </section>
</main>
</body>
</html>
