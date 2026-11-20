<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KartuKeluargaCrudController extends Controller
{
    private function families()
    {
        $query = KartuKeluarga::query();

        if (in_array(auth()->user()->role, ['warga', 'bendahara'], true)) {
            $query->where('owner_user_id', auth()->id());
        }

        return $query;
    }

    private function config(): array
    {
        $fields = ['nomor_kk', 'nama_kepala_keluarga', 'alamat', 'rt', 'rw'];
        if (auth()->user()->role === 'tenant_admin') {
            $fields[] = 'owner_user_id';
        }

        return [
            'title' => 'Kartu Keluarga',
            'model' => KartuKeluarga::class,
            'fields' => $fields,
        ];
    }

    private function tenantId(): int
    {
        return (int) (auth()->user()?->tenant_id ?? Tenant::query()->firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Komplek Default', 'status' => 'active']
        )->id);
    }

    private function rules(?KartuKeluarga $item = null): array
    {
        $rules = [
            'nomor_kk' => 'required|digits:16|unique:kartu_keluargas,nomor_kk,' . ($item?->id ?? 'NULL'),
            'nama_kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
        ];

        if (auth()->user()->role === 'tenant_admin') {
            $rules['owner_user_id'] = [
                'nullable',
                Rule::exists('users', 'id')->where('tenant_id', auth()->user()->tenant_id)
                    ->whereIn('role', ['warga', 'bendahara']),
            ];
        }

        return $rules;
    }

    private function formData(): array
    {
        if (auth()->user()->role !== 'tenant_admin') {
            return [];
        }

        return [
            'users' => User::query()
                ->where('tenant_id', auth()->user()->tenant_id)
                ->whereIn('role', ['warga', 'bendahara'])
                ->orderBy('name')
                ->get(['id', 'name', 'email']),
        ];
    }

    public function index()
    {
        $module = 'kartu-keluarga';
        $config = $this->config();
        $items = $this->families()->latest()->get();

        return view('crud.index', compact('module', 'config', 'items'));
    }

    public function create()
    {
        $module = 'kartu-keluarga';
        $config = $this->config();
        $item = null;
        $formData = $this->formData();

        return view('crud.form', compact('module', 'config', 'item') + $formData);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['tenant_id'] = $this->tenantId();
        if (in_array(auth()->user()->role, ['warga', 'bendahara'], true)) {
            $data['owner_user_id'] = auth()->id();
        }

        KartuKeluarga::query()->create($data);

        return redirect()->route('kartu-keluarga')->with('success', 'Data kartu keluarga berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $module = 'kartu-keluarga';
        $config = $this->config();
        $item = $this->families()->findOrFail($id);
        $formData = $this->formData();

        return view('crud.form', compact('module', 'config', 'item') + $formData);
    }

    public function update(Request $request, string $id)
    {
        $item = $this->families()->findOrFail($id);
        $item->update($request->validate($this->rules($item)));

        return redirect()->route('kartu-keluarga')->with('success', 'Data kartu keluarga berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $this->families()->findOrFail($id)->delete();

        return redirect()->route('kartu-keluarga')->with('success', 'Data kartu keluarga berhasil dihapus.');
    }
}
