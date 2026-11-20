<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Tenant;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WargaCrudController extends Controller
{
    private function families()
    {
        $query = KartuKeluarga::query();

        if (in_array(auth()->user()->role, ['warga', 'bendahara'], true)) {
            $query->where('owner_user_id', auth()->id());
        }

        return $query;
    }

    private function residents()
    {
        $query = Warga::query();

        if (in_array(auth()->user()->role, ['warga', 'bendahara'], true)) {
            $query->whereIn('kartu_keluarga_id', $this->families()->select('id'));
        }

        return $query;
    }

    private function config(): array
    {
        return [
            'title' => 'Data Warga',
            'model' => Warga::class,
            'fields' => ['kartu_keluarga_id', 'nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'status_pernikahan', 'status_keluarga', 'pekerjaan', 'nomor_hp'],
        ];
    }

    private function tenantId(): int
    {
        return (int) (auth()->user()?->tenant_id ?? Tenant::query()->firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Komplek Default', 'status' => 'active']
        )->id);
    }

    private function rules(?Warga $item = null): array
    {
        return [
            'kartu_keluarga_id' => [
                'required',
                Rule::exists('kartu_keluargas', 'id')->where(function ($query): void {
                    $user = auth()->user();
                    if ($user->tenant_id) {
                        $query->where('tenant_id', $user->tenant_id);
                    }
                    if (in_array($user->role, ['warga', 'bendahara'], true)) {
                        $query->where('owner_user_id', $user->id);
                    }
                }),
            ],
            'nik' => 'required|digits:16|unique:wargas,nik,' . ($item?->id ?? 'NULL'),
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'status_pernikahan' => 'required|in:Belum Menikah,Menikah,Cerai',
            'status_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Anggota',
            'pekerjaan' => 'nullable|string|max:255',
            'nomor_hp' => 'nullable|string|max:15',
        ];
    }

    public function index()
    {
        $module = 'warga';
        $config = $this->config();
        $items = $this->residents()->latest()->get();

        return view('crud.index', compact('module', 'config', 'items'));
    }

    public function create()
    {
        $module = 'warga';
        $config = $this->config();
        $item = null;
        $families = $this->families()->latest()->get();

        return view('crud.form', compact('module', 'config', 'item', 'families'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['tenant_id'] = $this->tenantId();

        Warga::query()->create($data);

        return redirect()->route('warga')->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $module = 'warga';
        $config = $this->config();
        $item = $this->residents()->findOrFail($id);
        $families = $this->families()->latest()->get();

        return view('crud.form', compact('module', 'config', 'item', 'families'));
    }

    public function update(Request $request, string $id)
    {
        $item = $this->residents()->findOrFail($id);
        $item->update($request->validate($this->rules($item)));

        return redirect()->route('warga')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $this->residents()->findOrFail($id)->delete();

        return redirect()->route('warga')->with('success', 'Data warga berhasil dihapus.');
    }
}
