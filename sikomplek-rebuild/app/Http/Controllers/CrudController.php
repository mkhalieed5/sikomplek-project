<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Warga;
use App\Models\KategoriIuran;
use App\Models\PembayaranIuran;
use App\Models\Tenant;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    private function config(string $module): array
    {
        return match ($module) {
            'kartu-keluarga' => ['title' => 'Kartu Keluarga', 'model' => KartuKeluarga::class, 'fields' => ['nomor_kk', 'nama_kepala_keluarga', 'alamat', 'rt', 'rw']],
            'warga' => ['title' => 'Data Warga', 'model' => Warga::class, 'fields' => ['kartu_keluarga_id', 'nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'status_pernikahan', 'status_keluarga', 'pekerjaan', 'nomor_hp']],
            'kategori-iuran' => ['title' => 'Kategori Iuran', 'model' => KategoriIuran::class, 'fields' => ['nama_kategori', 'nominal_default', 'deskripsi']],
            'pembayaran-iuran' => ['title' => 'Pembayaran Iuran', 'model' => PembayaranIuran::class, 'fields' => ['kartu_keluarga_id', 'kategori_iuran_id', 'bulan', 'tahun', 'jumlah_bayar', 'tanggal_bayar', 'status', 'catatan']],
            default => abort(404),
        };
    }

    private function tenantId(): int
    {
        return (int) (auth()->user()?->tenant_id ?? Tenant::query()->firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Komplek Default', 'status' => 'active']
        )->id);
    }

    private function rules(string $module, ?object $item = null): array
    {
        return match ($module) {
            'kartu-keluarga' => ['nomor_kk' => 'required|digits:16|unique:kartu_keluargas,nomor_kk,' . ($item?->id ?? 'NULL'), 'nama_kepala_keluarga' => 'required|string|max:255', 'alamat' => 'required|string', 'rt' => 'required|string|max:5', 'rw' => 'required|string|max:5'],
            'warga' => ['kartu_keluarga_id' => 'required|exists:kartu_keluargas,id', 'nik' => 'required|digits:16|unique:wargas,nik,' . ($item?->id ?? 'NULL'), 'nama_lengkap' => 'required|string|max:255', 'jenis_kelamin' => 'required|in:L,P', 'tempat_lahir' => 'required|string|max:255', 'tanggal_lahir' => 'required|date', 'status_pernikahan' => 'required|in:Belum Menikah,Menikah,Cerai', 'status_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Anggota', 'pekerjaan' => 'nullable|string|max:255', 'nomor_hp' => 'nullable|string|max:15'],
            'kategori-iuran' => ['nama_kategori' => 'required|string|max:255', 'nominal_default' => 'required|numeric|min:0', 'deskripsi' => 'nullable|string'],
            'pembayaran-iuran' => ['kartu_keluarga_id' => 'required|exists:kartu_keluargas,id', 'kategori_iuran_id' => 'required|exists:kategori_iurans,id', 'bulan' => 'required|integer|between:1,12', 'tahun' => 'required|integer|digits:4', 'jumlah_bayar' => 'required|numeric|min:0', 'tanggal_bayar' => 'required|date', 'status' => 'required|in:lunas,pending,batal', 'catatan' => 'nullable|string'],
        };
    }

    private function find(string $module, int $id): object
    {
        $model = $this->config($module)['model'];
        return $model::findOrFail($id);
    }

    public function index(string $module)
    {
        $config = $this->config($module);
        $items = $config['model']::latest()->get();
        return view('crud.index', compact('module', 'config', 'items'));
    }

    public function create(string $module)
    {
        $config = $this->config($module);
        $item = null;
        $families = KartuKeluarga::latest()->get();
        $categories = KategoriIuran::latest()->get();
        return view('crud.form', compact('module', 'config', 'item', 'families', 'categories'));
    }

    public function store(Request $request, string $module)
    {
        $config = $this->config($module);
        $data = $request->validate($this->rules($module));
        $data['tenant_id'] = $this->tenantId();
        $config['model']::create($data);
        return redirect()->route('crud.index', $module)->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(string $module, int $id)
    {
        $config = $this->config($module);
        $item = $this->find($module, $id);
        $families = KartuKeluarga::latest()->get();
        $categories = KategoriIuran::latest()->get();
        return view('crud.form', compact('module', 'config', 'item', 'families', 'categories'));
    }

    public function update(Request $request, string $module, int $id)
    {
        $item = $this->find($module, $id);
        $item->update($request->validate($this->rules($module, $item)));
        return redirect()->route('crud.index', $module)->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $module, int $id)
    {
        $this->find($module, $id)->delete();
        return redirect()->route('crud.index', $module)->with('success', 'Data berhasil dihapus.');
    }
}
