<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'bulan',
        'tahun',
        'nominal',
        'bukti_transfer',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
