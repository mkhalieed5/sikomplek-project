<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PembayaranIuran;
use Illuminate\Http\Request;

class PembayaranIuranController extends Controller
{
    private function rules(): array
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

    public function index() { return response()->json(['success' => true, 'data' => PembayaranIuran::with(['kartuKeluarga', 'kategoriIuran'])->latest()->get()]); }
    public function store(Request $request) { return response()->json(['success' => true, 'data' => PembayaranIuran::create($request->validate($this->rules()))], 201); }
    public function show(PembayaranIuran $pembayaranIuran) { return response()->json(['success' => true, 'data' => $pembayaranIuran->load(['kartuKeluarga', 'kategoriIuran'])]); }
    public function update(Request $request, PembayaranIuran $pembayaranIuran) { $pembayaranIuran->update($request->validate($this->rules())); return response()->json(['success' => true, 'data' => $pembayaranIuran]); }
    public function destroy(PembayaranIuran $pembayaranIuran) { $pembayaranIuran->delete(); return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dihapus']); }
}
