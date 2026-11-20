<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $fillable = [
        'tenant_id',
        'judul',
        'isi',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
