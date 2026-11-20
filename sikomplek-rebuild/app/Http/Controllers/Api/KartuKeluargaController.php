<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class KartuKeluargaController extends Controller
{
    private function families()
    {
        $query = KartuKeluarga::query();

        if (in_array(auth()->user()->role, ['warga', 'bendahara'], true)) {
            $query->where('owner_user_id', auth()->id());
        }

        return $query;
    }

    private function findAccessible(KartuKeluarga $kartuKeluarga): KartuKeluarga
    {
        return $this->families()->findOrFail($kartuKeluarga->id);
    }

    /**
     * Tampilkan semua Kartu Keluarga (Otomatis terfilter per Tenant)
     */
    public function index()
    {
        $kartuKeluarga = $this->families()->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $kartuKeluarga
        ]);
    }

    /**
     * Simpan Kartu Keluarga Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_kk' => 'required|numeric|digits:16|unique:kartu_keluargas,nomor_kk',
            'nama_kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
        ]);

        if (in_array($request->user()->role, ['warga', 'bendahara'], true)) {
            $validated['owner_user_id'] = $request->user()->id;
        }

        $kartuKeluarga = KartuKeluarga::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kartu Keluarga berhasil ditambahkan',
            'data' => $kartuKeluarga
        ], 201);
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga = $this->findAccessible($kartuKeluarga);

        return response()->json(['success' => true, 'data' => $kartuKeluarga->load('warga')]);
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga = $this->findAccessible($kartuKeluarga);
        $validated = $request->validate([
            'nomor_kk' => 'required|numeric|digits:16|unique:kartu_keluargas,nomor_kk,' . $kartuKeluarga->id,
            'nama_kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
        ]);
        $kartuKeluarga->update($validated);
        return response()->json(['success' => true, 'data' => $kartuKeluarga]);
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $this->findAccessible($kartuKeluarga)->delete();
        return response()->json(['success' => true, 'message' => 'Kartu Keluarga berhasil dihapus']);
    }
}