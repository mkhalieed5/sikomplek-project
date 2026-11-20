<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KartuKeluarga;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WargaController extends Controller
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

    private function findAccessible(Warga $warga): Warga
    {
        return $this->residents()->findOrFail($warga->id);
    }

    private function rules(?Warga $warga = null): array
    {
        $uniqueNik = 'unique:wargas,nik' . ($warga ? ',' . $warga->id : '');
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
            'nik' => ['required', 'digits:16', $uniqueNik],
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
        return response()->json(['success' => true, 'data' => $this->residents()->with('kartuKeluarga')->latest()->get()]);
    }

    public function store(Request $request)
    {
        return response()->json(['success' => true, 'data' => Warga::create($request->validate($this->rules()))], 201);
    }

    public function show(Warga $warga)
    {
        return response()->json(['success' => true, 'data' => $this->findAccessible($warga)->load('kartuKeluarga')]);
    }

    public function update(Request $request, Warga $warga)
    {
        $warga = $this->findAccessible($warga);
        $warga->update($request->validate($this->rules($warga)));

        return response()->json(['success' => true, 'data' => $warga]);
    }

    public function destroy(Warga $warga)
    {
        $this->findAccessible($warga)->delete();

        return response()->json(['success' => true, 'message' => 'Data warga berhasil dihapus']);
    }
}
