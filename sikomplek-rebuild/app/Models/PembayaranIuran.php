<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class PembayaranIuran extends Model
{
    use BelongsToTenant;
    protected $table = 'pembayaran_iurans';
    protected $fillable = ['tenant_id', 'kartu_keluarga_id', 'kategori_iuran_id', 'bulan', 'tahun', 'jumlah_bayar', 'tanggal_bayar', 'status', 'catatan'];
    protected $casts = ['tanggal_bayar' => 'date'];
    public function kartuKeluarga() { return $this->belongsTo(KartuKeluarga::class); }
    public function kategoriIuran() { return $this->belongsTo(KategoriIuran::class); }
}
