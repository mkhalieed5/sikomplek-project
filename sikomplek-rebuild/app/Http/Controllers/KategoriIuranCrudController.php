<?php

namespace App\Http\Controllers;

use App\Models\KategoriIuran;
use App\Models\Tenant;
use Illuminate\Http\Request;

class KategoriIuranCrudController extends Controller
{
    private function config(): array
    {
        return [
            'title' => 'Kategori Iuran',
            'model' => KategoriIuran::class,
            'fields' => ['nama_kategori', 'nominal_default', 'deskripsi'],
        ];
    }

    private function tenantId(): int
    {
        return (int) (auth()->user()?->tenant_id ?? Tenant::query()->firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Komplek Default', 'status' => 'active']
        )->id);
    }

    private function rules(?KategoriIuran $item = null): array
    {
        return [
            'nama_kategori' => 'required|string|max:255',
            'nominal_default' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ];
    }

    public function index()
    {
        $module = 'kategori-iuran';
        $config = $this->config();
        $items = KategoriIuran::query()->latest()->get();

        return view('crud.index', compact('module', 'config', 'items'));
    }

    public function create()
    {
        $module = 'kategori-iuran';
        $config = $this->config();
        $item = null;

        return view('crud.form', compact('module', 'config', 'item'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['tenant_id'] = $this->tenantId();

        KategoriIuran::query()->create($data);

        return redirect()->route('kategori-iuran')->with('success', 'Kategori iuran berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $module = 'kategori-iuran';
        $config = $this->config();
        $item = KategoriIuran::query()->findOrFail($id);

        return view('crud.form', compact('module', 'config', 'item'));
    }

    public function update(Request $request, string $id)
    {
        $item = KategoriIuran::query()->findOrFail($id);
        $item->update($request->validate($this->rules($item)));

        return redirect()->route('kategori-iuran')->with('success', 'Kategori iuran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        KategoriIuran::query()->findOrFail($id)->delete();

        return redirect()->route('kategori-iuran')->with('success', 'Kategori iuran berhasil dihapus.');
    }
}
