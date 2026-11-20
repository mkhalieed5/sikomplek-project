<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use BelongsToTenant;

    protected $table = 'wargas';

    protected $fillable = [
        'tenant_id', 'kartu_keluarga_id', 'nik', 'nama_lengkap',
        'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'status_pernikahan', 'status_keluarga', 'pekerjaan', 'nomor_hp',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }
}
