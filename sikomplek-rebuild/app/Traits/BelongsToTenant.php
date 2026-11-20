<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        // 1. Filter Otomatis (Global Scope) berdasarkan tenant user yang login
        static::addGlobalScope('tenant_id', function (Builder $builder) {
            if (auth()->check() && auth()->user()->tenant_id) {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });

        // 2. Isi tenant_id secara otomatis saat membuat data baru
        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->tenant_id && ! $model->tenant_id) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }

    /**
     * Relasi ke Model Tenant
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}