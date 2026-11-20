<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'code',
        'slug',
        'address',
        'alamat_jalan',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'kode_pos',
        'status',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function kartuKeluargas(): HasMany
    {
        return $this->hasMany(KartuKeluarga::class);
    }

    public function wargas(): HasMany
    {
        return $this->hasMany(Warga::class);
    }

    public function kategoriIurans(): HasMany
    {
        return $this->hasMany(KategoriIuran::class);
    }

    public function pembayaranIurans(): HasMany
    {
        return $this->hasMany(PembayaranIuran::class);
    }

    public function iurans(): HasMany
    {
        return $this->hasMany(Iuran::class);
    }

    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }

    public function pengumumans(): HasMany
    {
        return $this->hasMany(Pengumuman::class);
    }
}
