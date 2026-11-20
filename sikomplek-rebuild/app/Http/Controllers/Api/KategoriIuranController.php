<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriIuran;
use Illuminate\Http\Request;

class KategoriIuranController extends Controller
{
    public function index() { return response()->json(['success' => true, 'data' => KategoriIuran::latest()->get()]); }

    public function store(Request $request)
    {
        $data = $request->validate(['nama_kategori' => 'required|string|max:255', 'nominal_default' => 'required|numeric|min:0', 'deskripsi' => 'nullable|string']);
        return response()->json(['success' => true, 'data' => KategoriIuran::create($data)], 201);
    }

    public function show(KategoriIuran $kategoriIuran) { return response()->json(['success' => true, 'data' => $kategoriIuran]); }

    public function update(Request $request, KategoriIuran $kategoriIuran)
    {
        $kategoriIuran->update($request->validate(['nama_kategori' => 'required|string|max:255', 'nominal_default' => 'required|numeric|min:0', 'deskripsi' => 'nullable|string']));
        return response()->json(['success' => true, 'data' => $kategoriIuran]);
    }

    public function destroy(KategoriIuran $kategoriIuran)
    {
        $kategoriIuran->delete();
        return response()->json(['success' => true, 'message' => 'Kategori iuran berhasil dihapus']);
    }
}
