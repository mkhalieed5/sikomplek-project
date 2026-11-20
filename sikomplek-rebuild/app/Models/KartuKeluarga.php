<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'owner_user_id', 'nomor_kk', 'nama_kepala_keluarga', 'alamat', 'rt', 'rw'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function warga()
    {
        return $this->hasMany(Warga::class);
    }
}
