<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\KategoriIuran;
use App\Models\PembayaranIuran;
use App\Models\Tenant;
use Illuminate\Http\Request;

class PembayaranIuranCrudController extends Controller
{
    private function config(): array
    {
        return [
            'title' => 'Pembayaran Iuran',
            'model' => PembayaranIuran::class,
            'fields' => ['kartu_keluarga_id', 'kategori_iuran_id', 'bulan', 'tahun', 'jumlah_bayar', 'tanggal_bayar', 'status', 'catatan'],
        ];
    }

    private function tenantId(): int
    {
        return (int) (auth()->user()?->tenant_id ?? Tenant::query()->firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Komplek Default', 'status' => 'active']
        )->id);
    }

    private function rules(?PembayaranIuran $item = null): array
    {
        return [
            'kartu_keluarga_id' => 'required|exists:kartu_keluargas,id',
            'kategori_iuran_id' => 'required|exists:kategori_iurans,id',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|digits:4',
            'jumlah_bayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,pending,batal',
            'catatan' => 'nullable|string',
        ];
    }

    public function index()
    {
        $module = 'pembayaran-iuran';
        $config = $this->config();
        $items = PembayaranIuran::query()->latest()->get();

        return view('crud.index', compact('module', 'config', 'items'));
    }

    public function create()
    {
        $module = 'pembayaran-iuran';
        $config = $this->config();
        $item = null;
        $families = KartuKeluarga::query()->latest()->get();
        $categories = KategoriIuran::query()->latest()->get();

        return view('crud.form', compact('module', 'config', 'item', 'families', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['tenant_id'] = $this->tenantId();

        PembayaranIuran::query()->create($data);

        return redirect()->route('pembayaran-iuran')->with('success', 'Pembayaran iuran berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $module = 'pembayaran-iuran';
        $config = $this->config();
        $item = PembayaranIuran::query()->findOrFail($id);
        $families = KartuKeluarga::query()->latest()->get();
        $categories = KategoriIuran::query()->latest()->get();

        return view('crud.form', compact('module', 'config', 'item', 'families', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $item = PembayaranIuran::query()->findOrFail($id);
        $item->update($request->validate($this->rules($item)));

        return redirect()->route('pembayaran-iuran')->with('success', 'Pembayaran iuran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        PembayaranIuran::query()->findOrFail($id)->delete();

        return redirect()->route('pembayaran-iuran')->with('success', 'Pembayaran iuran berhasil dihapus.');
    }
}
